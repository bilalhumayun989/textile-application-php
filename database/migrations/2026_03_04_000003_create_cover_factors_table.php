<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cover_factors', function (Blueprint $table) {
            $table->id();

            $table->integer('ends');
            $table->integer('picks');

            $table->float('warp_count');
            $table->float('weft_count');

            // derived values
            $table->float('warp_term');
            $table->float('weft_term');
            $table->float('cover_factor');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cover_factors');
    }
};
