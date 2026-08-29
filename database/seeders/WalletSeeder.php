<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = Wallet::firstOrCreate(
            ['name' => 'Safiullah zafar'],
            [
                'email' => 'safiullah@example.com',
                'phone' => '0000000000',
            ]
        );

        // Seed some experiment data for expenses
        // 2 days ago
        $wallet->entries()->create([
            'type' => 'debit',
            'amount' => 500.00,
            'description' => 'Office Supplies',
            'created_at' => now()->subDays(2)->setHour(10),
        ]);
        $wallet->entries()->create([
            'type' => 'credit',
            'amount' => 1200.00,
            'description' => 'Refund from Vendor',
            'created_at' => now()->subDays(2)->setHour(14),
        ]);

        // 1 day ago
        $wallet->entries()->create([
            'type' => 'debit',
            'amount' => 150.00,
            'description' => 'Lunch Meeting',
            'created_at' => now()->subDays(1)->setHour(13),
        ]);
        $wallet->entries()->create([
            'type' => 'debit',
            'amount' => 300.00,
            'description' => 'Advertising',
            'created_at' => now()->subDays(1)->setHour(16),
        ]);
    }
}
