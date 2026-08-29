<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletEntry;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\Bank;

class WalletController extends Controller
{
    public function index()
    {
        // For this requirement, there's only one wallet
        // Since names are encrypted, we fetch all and filter in PHP
        $wallet = Wallet::all()->filter(fn($w) => $w->name === 'Safiullah zafar')->first();
        if ($wallet) {
            return redirect()->route('wallets.show', $wallet->id);
        }
        
        return view('wallets.index', ['wallets' => []]);
    }

    public function create()
    {
        return view('wallets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        Wallet::create($data);

        return redirect()->route('wallets.index')->with('status', 'Wallet created successfully.');
    }

    public function show(Wallet $wallet)
    {
        $entries = $wallet->entries()->orderBy('created_at')->get();
        // Get all users to show in the dropdown for creating a transaction
        // Get all customers to show in the dropdown for creating a transaction
        $customers = Customer::orderBy('name')->get();
        return view('wallets.show', compact('wallet', 'entries', 'customers'));
    }

    public function storeEntry(Request $request, Wallet $wallet)
    {
        $data = $request->validate([
            'customer_id' => 'required',
            'type' => 'required|in:rec,pay',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'bank_id' => 'required_if:payment_method,Bank|nullable|exists:banks,id',
        ]);

        $entryType = $data['type'] === 'rec' ? 'credit' : 'debit';
        $method = !empty($data['payment_method']) ? $data['payment_method'] : 'Cash/Check';
        $finalDescription = $data['description'] ?? ($data['type'] === 'rec' ? 'Received' : 'Paid');

        // PRE-VALIDATE BANK BALANCE if it's a payment
        if ($method === 'Bank' && $data['type'] === 'pay' && !empty($data['bank_id'])) {
            $bank = Bank::find($data['bank_id']);
            if ($bank && $bank->balance < $data['amount']) {
                return back()->with('error', 'not enough money chooses some other bank/method')->withInput();
            }
        }

        // Cash/Check payments always allowed — balance can go negative, net view will reflect it

        if ($data['customer_id'] === 'other') {
            // It's a personal/general entry
            $wallet->entries()->create([
                'type' => $entryType,
                'amount' => $data['amount'],
                'description' => $finalDescription,
                'payment_method' => $method,
            ]);

            // Sync with Bank if needed
            if ($method === 'Bank' && !empty($data['bank_id'])) {
                $bank = \App\Models\Bank::find($data['bank_id']);
                if ($bank) {
                    if ($entryType === 'credit') {
                        $bank->balance += $data['amount'];
                    } else {
                        $bank->balance -= $data['amount'];
                    }
                    $bank->save();
                }
            }
        } else {
            // Transaction for a specific customer
            $customer = Customer::findOrFail($data['customer_id']);
            $txType = $data['type'] === 'rec' ? 'payment_received' : 'sale';
            
            $debit = $txType === 'sale' ? $data['amount'] : 0;
            $credit = $txType === 'payment_received' ? $data['amount'] : 0;
 
            // Running balance calculation
            $lastTx = CustomerTransaction::where('customer_id', $customer->id)->latest('id')->first();
            $previousBalance = $lastTx ? $lastTx->balance : 0;
            $newBalance = $previousBalance + $debit - $credit;
 
            CustomerTransaction::create([
                'customer_id' => $customer->id,
                'type' => $txType,
                'debit' => $debit,
                'credit' => $credit,
                'balance' => $newBalance,
                'description' => $finalDescription,
                'payment_method' => $method,
            ]);

            // Sync with Bank if needed
            if ($method === 'Bank' && !empty($data['bank_id'])) {
                $bank = \App\Models\Bank::find($data['bank_id']);
                if ($bank) {
                    if ($credit > 0) {
                        $bank->balance += $credit;
                    } else {
                        $bank->balance -= $debit;
                    }
                    $bank->save();
                }
            }
        }

        return redirect()->back()->with('status', 'Entry added successfully.');
    }

    public function expenses(Request $request, Wallet $wallet)
    {
        $view = $request->query('view', 'all'); // 'all', 'personal', or 'customer' - default to all
        $cutoff = now()->startOfDay();

        $allEntries = collect();
        $totalReceived = 0;
        $totalSpent = 0;

        // Get personal entries
        if ($view === 'all' || $view === 'personal') {
            $personalEntries = $wallet->entries()->orderBy('created_at', 'desc')->get();
            foreach ($personalEntries as $entry) {
                $allEntries->push([
                    'id' => $entry->id,
                    'created_at' => $entry->created_at,
                    'type' => 'personal',
                    'entry_type' => $entry->type,
                    'amount' => $entry->amount,
                    'description' => $entry->description,
                    'payment_method' => $entry->payment_method,
                    'customer_name' => null,
                    'credit' => in_array($entry->type, ['rec', 'credit']) ? $entry->amount : 0,
                    'debit' => in_array($entry->type, ['exp', 'debit']) ? $entry->amount : 0,
                ]);
                
                if (in_array($entry->type, ['rec', 'credit'])) {
                    $totalReceived += $entry->amount;
                } else {
                    $totalSpent += $entry->amount;
                }
            }
        }

        // Get customer entries
        if ($view === 'all' || $view === 'customer') {
            $customerEntries = CustomerTransaction::with('customer')->orderBy('created_at', 'desc')->get();
            foreach ($customerEntries as $entry) {
                $allEntries->push([
                    'id' => $entry->id,
                    'created_at' => $entry->created_at,
                    'type' => 'customer',
                    'entry_type' => $entry->type,
                    'amount' => max($entry->credit, $entry->debit),
                    'description' => $entry->description,
                    'payment_method' => $entry->payment_method,
                    'customer_name' => $entry->customer?->name,
                    'credit' => $entry->credit,
                    'debit' => $entry->debit,
                ]);
                
                $totalReceived += $entry->credit;
                $totalSpent += $entry->debit;
            }
        }

        // Sort all entries by date
        $allEntries = $allEntries->sortByDesc('created_at');

        $groupedExpenses = $allEntries->groupBy(function($e) {
            return $e['created_at']->format('Y-m-d');
        });

        return view('wallets.expenses', compact('wallet', 'groupedExpenses', 'view', 'totalReceived', 'totalSpent'));
    }

//     public function expenses(Wallet $wallet)
// {
//     $entries = $wallet->entries()->orderBy('created_at', 'desc')->get();

//     $cutoff = now()->subDay()->startOfDay();

//     $recentExpenses = $entries->filter(function ($e) use ($cutoff) {
//         return $e->created_at >= $cutoff;
//     })->groupBy(function ($e) {
//         return $e->created_at->format('Y-m-d');
//     });

//     $pastExpenses = $entries->filter(function ($e) use ($cutoff) {
//         return $e->created_at < $cutoff;
//     })->groupBy(function ($e) {
//         return $e->created_at->format('Y-m-d');
//     });

//     return view('wallets.expenses', compact('wallet', 'recentExpenses', 'pastExpenses'));
// }
    public function destroy(Wallet $wallet)
    {
        $wallet->entries()->delete();
        $wallet->delete();
        return redirect()->route('wallets.index')->with('status', 'Wallet deleted.');
    }

    public function destroyEntry(WalletEntry $entry)
    {
        $entry->delete();
        return redirect()->back()->with('status', 'Record deleted successfully.');
    }
}
