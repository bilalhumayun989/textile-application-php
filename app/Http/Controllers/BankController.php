<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Wallet;
use App\Models\WalletEntry;

class BankController extends Controller
{
    public function index()
    {
        // Since wallet names are encrypted, filter the collection in PHP
        $wallet = Wallet::all()->filter(fn($w) => $w->name === 'Safiullah zafar')->first();
        if (!$wallet) {
            $wallet = Wallet::first();
        }

        $banks = Bank::where('wallet_id', $wallet->id)->get();
        
        return view('banks.index', compact('banks', 'wallet'));
    }

    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $newBalance = $request->amount;
        $oldBalance = $bank->balance;
        $difference = abs($newBalance - $oldBalance);

        if ($difference == 0) {
            return back()->with('info', 'No change in balance.');
        }

        if ($newBalance > $oldBalance) {
            // Balance increased, treat as credit to wallet
            $bank->wallet->entries()->create([
                'type' => 'credit',
                'amount' => $difference,
                'description' => "Bank balance adjusted (Up) for {$bank->name}",
                'payment_method' => 'bank',
            ]);
        } else {
            // Balance decreased, treat as debit from wallet
            $bank->wallet->entries()->create([
                'type' => 'debit',
                'amount' => $difference,
                'description' => "Bank balance adjusted (Down) for {$bank->name}",
                'payment_method' => 'bank',
            ]);
        }

        $bank->balance = $newBalance;
        $bank->save();

        return back()->with('status', 'Bank balance updated to absolute value.');
    }
}
