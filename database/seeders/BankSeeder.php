<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the main wallet
        $wallet = \App\Models\Wallet::where('name', 'Safiullah zafar')->first();
        if (!$wallet) {
            $wallet = \App\Models\Wallet::first();
        }

        $banks = [
            ['name' => 'Meezan Bank', 'balance' => 0],
            ['name' => 'HBL', 'balance' => 0],
            ['name' => 'Faysal Bank', 'balance' => 0],
            ['name' => 'UBL', 'balance' => 0],
            ['name' => 'Bank Al Habib', 'balance' => 0],
            ['name' => 'Allied Bank', 'balance' => 0],
        ];

        foreach ($banks as $bank) {
            Bank::create(array_merge($bank, ['wallet_id' => $wallet?->id]));
        }
    }
}
