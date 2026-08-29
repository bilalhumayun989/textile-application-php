<?php

namespace Tests\Unit;

use App\Models\CustomerTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class CustomerTransactionTest extends TestCase
{
    // manually create minimal tables for the test environment

    protected function setUp(): void
    {
        parent::setUp();

        // drop any existing tables (including the old typo one) and reset sqlite auto-increment sequences
        Schema::dropIfExists('custome_transactions');
        Schema::dropIfExists('customer_transactions');
        Schema::dropIfExists('users');
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::statement('DELETE FROM sqlite_sequence WHERE name IN ("users","customer_transactions");');
        DB::statement('PRAGMA foreign_keys = ON;');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('customer_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users');
            $table->enum('type', ['opening_balance','deposit','sale','payment_received','return','discount']);
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->timestamps();
        });

    }

    /**
     * A new customer transaction should compute running balance correctly.
     */
    public function test_running_balance_accumulates()
    {
        $customer = User::factory()->create();

        // opening balance of 500 (debit)
        $tx1 = CustomerTransaction::create([
            'customer_id' => $customer->id,
            'type' => 'opening_balance',
            'debit' => 500,
            'credit' => 0,
        ]);

        // first transaction should have balance equal to debit since no previous record exists

        $this->assertDatabaseHas('customer_transactions', [
            'customer_id' => $customer->id,
            'balance' => 500,
        ]);

        // sale 200 (debit)
        CustomerTransaction::create([
            'customer_id' => $customer->id,
            'type' => 'sale',
            'debit' => 200,
            'credit' => 0,
        ]);

        $this->assertDatabaseHas('customer_transactions', [
            'customer_id' => $customer->id,
            'balance' => 700,
        ]);

        // payment 300 (credit)
        CustomerTransaction::create([
            'customer_id' => $customer->id,
            'type' => 'payment_received',
            'debit' => 0,
            'credit' => 300,
        ]);

        $this->assertDatabaseHas('customer_transactions', [
            'customer_id' => $customer->id,
            'balance' => 400, // 700 - 300
        ]);
    }
}
