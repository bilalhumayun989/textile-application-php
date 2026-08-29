<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('email')->nullable()->change();
            $table->text('phone')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->text('contact_info')->nullable()->change();
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('email')->nullable()->change();
            $table->text('phone')->nullable()->change();
        });

        Schema::table('wallet_entries', function (Blueprint $table) {
            $table->text('amount')->change();
            $table->text('description')->nullable()->change();
            $table->text('payment_method')->nullable()->change();
        });

        Schema::table('customer_transactions', function (Blueprint $table) {
            $table->text('debit')->change();
            $table->text('credit')->change();
            $table->text('balance')->change();
            $table->text('description')->nullable()->change();
        });

        Schema::table('wallet_nets', function (Blueprint $table) {
            $table->text('received_total')->change();
            $table->text('used_total')->change();
            $table->text('net_amount')->change();
            $table->text('focus')->change();
        });

        Schema::table('banks', function (Blueprint $table) {
            $table->text('balance')->change();
        });
    }

    public function down(): void
    {
        // down logic omitted for brevity as discussed
    }
};
