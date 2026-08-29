<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('custome_transactions')) {
            Schema::drop('custome_transactions');
        }
    }

    public function down(): void
    {
        // no-op; the table was a mistake and should not be recreated
    }
};