<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Wallet;
use App\Models\CustomerTransaction;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    // Removal of WithoutModelEvents as we rely on 'creating' events for financials
    // use WithoutModelEvents;

    public function run(): void
    {
        // 1. Create the Admin User for Login (used in AuthController)
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );

        // 2. Create the Admin record for special actions (used in RunBalanceController::destroyCustomer)
        Admin::updateOrCreate(
            ['name' => 'admin'],
            [
                'password' => Hash::make('12345678'),
            ]
        );

        // 3. Run Other Seeders
        $this->call([
            WalletSeeder::class,
            BankSeeder::class,
        ]);

        // 3. Create a Test Customer (Separate from User)
        $customer = Customer::create([
            'name' => 'Test Customer',
            'email' => 'customer' . time() . '@example.com',
        ]);

        // 4. Set up Financials
        $wallet = Wallet::where('name', 'Safiullah zafar')->first() ?: Wallet::first();
        if ($wallet) {
            $wallet->entries()->create([
                'type' => 'credit',
                'amount' => 10000,
                'description' => 'Opening Balance',
                'payment_method' => 'Amount',
            ]);
        }

        // 5. Create Test Transactions for the Customer
        CustomerTransaction::create([
            'customer_id' => $customer->id,
            'type' => 'opening_balance',
            'debit' => 1000,
            'credit' => 0,
            'description' => 'Account opened with due amount',
        ]);

        CustomerTransaction::create([
            'customer_id' => $customer->id,
            'type' => 'sale',
            'debit' => 250,
            'credit' => 0,
            'description' => 'Fabric purchase',
        ]);

        CustomerTransaction::create([
            'customer_id' => $customer->id,
            'type' => 'payment_received',
            'debit' => 0,
            'credit' => 300,
            'description' => 'Payment from customer',
        ]);
    }
}
