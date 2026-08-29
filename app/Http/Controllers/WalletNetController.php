<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletNet;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\Bank;

class WalletNetController extends Controller
{
    public function index(Request $request)
    {
        $wallets = Wallet::all();
        // Since wallet names are now encrypted, we filter the collection in PHP
        $mainWallet = $wallets->filter(fn($w) => $w->name === 'Safiullah zafar')->first() ?? $wallets->first();
        
        $selectedWalletId = $request->query('wallet_id', $mainWallet?->id);
        $selectedDateFrom = $request->filled('date_from') ? $request->query('date_from') : now()->format('Y-m-d');
        $selectedDateTo = $request->filled('date_to') ? $request->query('date_to') : now()->format('Y-m-d');
        $selectedCustomerId = $request->query('customer_id', 'all');

        // Logic flags based on query params
        $showResults = $request->has('show_data') || $request->has('recorded');
        $showBreakdown = $request->has('show_data');

        $received = 0;
        $used = 0;
        $net = null;
        $breakdown = [];

        if ($showResults) {
            $data = $this->calculateNet($selectedWalletId, $selectedDateFrom, $selectedDateTo, $selectedCustomerId);
            $received = $data['received'];
            $used = $data['used'];
            $net = $data['net'];
            $breakdown = $data['breakdown'];
        }

        $allRecords = WalletNet::with('wallet')->orderBy('created_at', 'desc')->get();
        $groupedNetRecords = $allRecords->groupBy(function($r) {
            return $r->created_at->format('Y-m-d');
        });

        // ── Live Asset Totals ──────────────────────────────────────────────
        // All wallets combined (not filtered by selected wallet) for true live overview
        $allWalletIds = $wallets->pluck('id');

        // Bank total: sum of all bank balances across all wallets
        $liveTotalBank = Bank::whereIn('wallet_id', $allWalletIds)->get()->sum('balance');

        // Cash total: wallet entries with payment_method = Amount/Cash (not Check/Bank)
        $liveTotalCash = 0;
        // Check/Cheque total: wallet entries with payment_method = Check/Cheque
        $liveTotalCheck = 0;

        foreach ($wallets as $w) {
            $entries = $w->entries()->get();

            foreach ($entries as $entry) {
                $amt      = (float) $entry->amount;
                $pm       = strtolower($entry->payment_method ?? 'cash/check');
                $isCredit = $entry->type === 'credit';

                if (in_array($pm, ['check', 'cheque'])) {
                    $liveTotalCheck += $isCredit ? $amt : -$amt;
                } elseif ($pm !== 'bank') {
                    $liveTotalCash += $isCredit ? $amt : -$amt;
                }
            }
        }

        // Also factor in customer transactions (these are NOT duplicated in wallet entries)
        $allCustomerTx = CustomerTransaction::all();
        foreach ($allCustomerTx as $tx) {
            $pm = strtolower($tx->payment_method ?? 'cash/check');
            $cr = (float) $tx->credit;
            $db = (float) $tx->debit;

            if (in_array($pm, ['check', 'cheque'])) {
                $liveTotalCheck += $cr - $db;
            } elseif ($pm !== 'bank') {
                $liveTotalCash += $cr - $db;
            }
        }

        // Combined cash + check for the single card
        $liveTotalCashCheck = $liveTotalCash + $liveTotalCheck;

        $customers = Customer::orderBy('name')->get();

        return view('wallets.net', compact(
            'wallets',
            'customers',
            'selectedWalletId',
            'selectedDateFrom',
            'selectedDateTo',
            'selectedCustomerId',
            'net',
            'groupedNetRecords',
            'received',
            'used',
            'breakdown',
            'showResults',
            'showBreakdown',
            'liveTotalBank',
            'liveTotalCash',
            'liveTotalCheck',
            'liveTotalCashCheck'
        ));
    }

    /**
     * Handle the recording of a Net calculation via POST.
     */
    public function store(Request $request)
    {
        $walletId = $request->input('wallet_id');
        $dateFrom = $request->input('date_from', now()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $customerId = $request->input('customer_id', 'all');

        $data = $this->calculateNet($walletId, $dateFrom, $dateTo, $customerId);

        // Determine focus name
        $focusName = 'All Records';
        if ($customerId === 'personal') {
            $focusName = 'Personal Expenses';
        } elseif ($customerId !== 'all') {
            $customer = Customer::find($customerId);
            $focusName = $customer ? $customer->name : 'Unknown Customer';
        }

        WalletNet::create([
            'wallet_id' => $walletId,
            'received_total' => $data['received'],
            'used_total' => $data['used'],
            'net_amount' => $data['net'],
            'focus' => $focusName . " ({$dateFrom} to {$dateTo})",
        ]);

        return redirect()->route('wallets.net', [
            'wallet_id' => $walletId,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'customer_id' => $customerId,
            'recorded' => 1
        ])->with('status', 'Net calculation recorded successfully.');
    }

    /**
     * Reusable calculation logic for both viewing and recording.
     */
    private function calculateNet($walletId, $dateFrom, $dateTo, $customerId)
    {
        $received = 0;
        $used = 0;
        $breakdown = [];
        
        $wallet = Wallet::find($walletId);
        if (!$wallet) return ['received' => 0, 'used' => 0, 'net' => 0, 'breakdown' => []];

        $start = $dateFrom . ' 00:00:00';
        $end = $dateTo . ' 23:59:59';

        // 1. Wallet Entries (Personal) - Included if 'all' or 'personal'
        if ($customerId === 'all' || $customerId === 'personal') {
            $walletEntries = $wallet->entries()
                ->whereBetween('created_at', [$start, $end])
                ->get();
            
            foreach ($walletEntries as $entry) {
                $amt = (float)$entry->amount;
                // Since enum is credit/debit in DB
                if ($entry->type === 'credit') {
                    $received += $amt;
                } else {
                    $used += $amt;
                }
                $breakdown[] = [
                    'type' => 'Personal',
                    'desc' => $entry->description ?? 'Expense',
                    'amount' => $amt,
                    'kind' => $entry->type === 'credit' ? 'credit' : 'debit'
                ];
            }
        }

        // 2. Customer Ledgers - Included if 'all' or a specific customer numeric ID
        if ($customerId !== 'personal') {
            $txQuery = CustomerTransaction::with('customer')
                ->whereBetween('created_at', [$start, $end]);
            
            if ($customerId !== 'all') {
                $txQuery->where('customer_id', $customerId);
            }

            $transactions = $txQuery->get();

            foreach ($transactions as $tx) {
                $cr = (float)$tx->credit;
                $db = (float)$tx->debit;
                $received += $cr;
                $used += $db;
                
                $breakdown[] = [
                    'type' => 'Ledger',
                    'desc' => "Customer: " . ($tx->customer?->name ?? 'Unknown'),
                    'amount' => $cr > 0 ? $cr : $db,
                    'kind' => $cr > 0 ? 'credit' : 'debit'
                ];
            }
        }

        // 3. Bank entries within the date range (wallet entries with payment_method = bank)
        // These are already included in wallet entries above via the personal section,
        // but we also add the raw bank balance snapshot for the selected wallet
        $banks = Bank::where('wallet_id', $walletId)->get();
        foreach ($banks as $bank) {
            $bal = (float) $bank->balance;
            if ($bal != 0) {
                if ($bal > 0) {
                    $received += $bal;
                    $breakdown[] = [
                        'type' => 'Bank',
                        'desc' => 'Bank: ' . $bank->name,
                        'amount' => $bal,
                        'kind' => 'credit'
                    ];
                } else {
                    $used += abs($bal);
                    $breakdown[] = [
                        'type' => 'Bank',
                        'desc' => 'Bank: ' . $bank->name,
                        'amount' => abs($bal),
                        'kind' => 'debit'
                    ];
                }
            }
        }

        return [
            'received' => $received,
            'used' => $used,
            'net' => $received - $used,
            'breakdown' => $breakdown
        ];
    }

    public function destroy(WalletNet $net)
    {
        $net->delete();
        return redirect()->back()->with('status', 'Net record deleted.');
    }
}
