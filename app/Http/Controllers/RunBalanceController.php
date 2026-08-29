<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Bank;

class RunBalanceController extends Controller
{
    /**
     * Display the ledger page, optionally filtered by customer.
     */
    public function index(Request $request)
    {
        try {
            $customers = Customer::orderBy('name')->get();
            
            // Fetch banks for selection
            // Fetch banks for selection
            $wallets = Wallet::all();
            $wallet = $wallets->filter(fn($w) => $w->name === 'Safiullah zafar')->first() ?: $wallets->first();
            $banks = Bank::where('wallet_id', $wallet?->id)->get();
            
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->view('run_balance', [
                'customers' => collect(),
                'selected' => null,
                'transactions' => collect(),
                'banks' => collect(),
                'error' => 'Database is not ready: please run migrations.',
            ], 500);
        }

        $selected = $request->query('customer_id');
        $transactions = collect();

        if ($selected) {
            $transactions = CustomerTransaction::where('customer_id', $selected)
                ->orderBy('created_at')
                ->get();
        }

        return view('run_balance', compact('customers', 'selected', 'transactions', 'banks'));
    }

    /**
     * Store a new transaction for a customer and update balance.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|in:opening_balance,deposit,sale,payment_received,return,discount',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'bank_id' => 'required_if:payment_method,Bank|nullable|exists:banks,id',
        ]);

        $wallets = Wallet::all();
        $wallet = $wallets->filter(fn($w) => $w->name === 'Safiullah zafar')->first() ?: $wallets->first();
        if (!$wallet) {
            return back()->with('error', 'Primary wallet not found.');
        }

        // 1. Fetch current customer ledger balance
        $lastTx = CustomerTransaction::where('customer_id', $data['customer_id'])
            ->latest('id')
            ->first();
        $previousBalance = $lastTx ? $lastTx->balance : 0;

        // 2. Classify Transaction Flow
        $isOutward = in_array($data['type'], ['sale', 'opening_balance', 'deposit']); // Money leaving our possession (or debt added)
        $isInward  = in_array($data['type'], ['payment_received', 'return']);        // Money coming in (or debt reduced)
        
        $debit = 0;  // Increases what customer owes us
        $credit = 0; // Decreases what customer owes us
        $finalDescription = $data['description'] ?? null;

        if ($data['type'] === 'discount') {
            $percentage = $data['amount'];
            $credit = ($previousBalance * $percentage) / 100;
            $finalDescription = ($finalDescription ? $finalDescription . " " : "") . "(" . $percentage . "% Discount)";
        } else {
            if ($isOutward) {
                $debit = $data['amount'];
            } elseif ($isInward) {
                $credit = $data['amount'];
            }
        }

        // 3. Banking Connectivity & Strict Balance Check
        $method = !empty($data['payment_method']) ? $data['payment_method'] : 'Cash/Check';
        $syncEntry = null;

        if ($method === 'Bank' && !empty($data['bank_id'])) {
            $bank = Bank::find($data['bank_id']);
            if (!$bank) {
                return back()->with('error', 'Selected bank not found.');
            }

            // Strict check: if it's money leaving our bank (e.g. we pay for a sale/stock OR give a deposit back)
            // Note: In your logic, 'sale' means we are recording a debt for the customer, 
            // but if it's via BANK, it implies we likely paid something out (stock/cost).
            // If it's 'deposit', we are receiving money FROM customer? 
            // Wait, let's look at the customer perspective:
            // Customer 'deposit' (Credit) = Money coming IN.
            // Customer 'sale' (Debit) = Money going OUT (our stock/cash).
            
            // LET'S ALIGN WITH YOUR USER REQUEST: "if not enough money in bank it ask not enough money"
            
            if ($debit > 0) { // Outward flow (recorded as debit for customer)
                if ($bank->balance < $debit) {
                    return back()->with('error', "Insufficient funds in {$bank->name}. Current balance: " . number_format($bank->balance, 2));
                }
                $bank->balance -= $debit;
                $syncEntry = ['type' => 'debit', 'amount' => $debit, 'method' => 'bank', 'desc' => "(Paid via {$bank->name}) " . ($finalDescription ?: "Sale/Opening")];
            } elseif ($credit > 0) { // Inward flow
                $bank->balance += $credit;
                $syncEntry = ['type' => 'credit', 'amount' => $credit, 'method' => 'bank', 'desc' => "(Received in {$bank->name}) " . ($finalDescription ?: "Payment/Return")];
            }
            $bank->save();
        } elseif ($method === 'Check' || $method === 'Amount' || $method === 'Cash/Check' || $method === 'Cash') {
            // Cash/Check: CustomerTransaction already tracks this money.
            // Do NOT create a WalletEntry sync — that would double-count in net calculations.
            // Just set finalDescription for the ledger record.
            if ($debit > 0) {
                $finalDescription = "({$method} Out) " . ($finalDescription ?: "Transaction");
            } elseif ($credit > 0) {
                $finalDescription = "({$method} In) " . ($finalDescription ?: "Transaction");
            }
        }

        // 4. Sync with Wallet Entries
        if ($syncEntry) {
            $wallet->entries()->create([
                'type' => $syncEntry['type'],
                'amount' => $syncEntry['amount'],
                'description' => $syncEntry['desc'],
                'payment_method' => $syncEntry['method'],
            ]);
            $finalDescription = $syncEntry['desc'];
        }

        // 5. Save Ledger Transaction
        $newBalance = $previousBalance + $debit - $credit;

        CustomerTransaction::create([
            'customer_id' => $data['customer_id'],
            'type' => $data['type'],
            'debit' => $debit,
            'credit' => $credit,
            'balance' => $newBalance,
            'description' => $finalDescription,
            'payment_method' => $method,
        ]);

        return redirect()->route('run_balance.index', ['customer_id' => $data['customer_id']])
            ->with('status', 'Transaction saved and synced successfully.');
    }

    /**
     * Delete a customer record after verifying admin credentials.
     */
    public function destroyCustomer(Request $request)
    {
        $data = $request->validate([
            'customer_id'    => 'required|integer|exists:customers,id',
            'admin_name'     => 'required|string',
            'admin_password' => 'required|string',
        ]);

        // Find the admin record by name in the admins table
        // Since admin names are likely not encrypted yet (or we filter them now)
        // I will assume Admin name is NOT encrypted for now as it's for system access, 
        // but if the user wants ALL data encrypted, I should stick to it.
        // Let's check Admin model first if it exists.
        $admin = Admin::all()->filter(fn($a) => $a->name === $data['admin_name'])->first();

        if (! $admin || ! Hash::check($data['admin_password'], $admin->password)) {
            return redirect()->route('run_balance.index')
                ->with('delete_error', 'Invalid admin name or password. Customer was not deleted.');
        }

        $customer = Customer::findOrFail($data['customer_id']);

        // Remove associated transactions first
        CustomerTransaction::where('customer_id', $customer->id)->delete();
        $customer->delete();

        return redirect()->back()
            ->with('status', 'Customer "' . $customer->name . '" deleted successfully.');
    }

    /**
     * Show the form for adding a new customer.
     */
    public function showCustomerForm()
    {
        return view('run_balance_customer_create');
    }

    /**
     * Add a new customer record from the ledger page.
     */
    public function storeCustomer(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'contact_info' => 'nullable|string',
        ]);

        $customer = Customer::create($data);

        // return to ledger page
        return redirect()->route('run_balance.index', ['customer_id' => $customer->id])
            ->with('status', 'Customer added successfully.');
    }

    /**
     * Delete a single transaction.
     */
    public function destroyTransaction(CustomerTransaction $transaction)
    {
        $transaction->delete();
        return redirect()->back()->with('status', 'Transaction deleted successfully.');
    }
}
