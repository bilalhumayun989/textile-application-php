<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blend_ratios', function (Blueprint $table) {
            $table->id();

            $table->integer('ends');
            $table->integer('picks');

            $table->float('warp_cotton');
            $table->float('warp_polyester');

            $table->float('weft_cotton');
            $table->float('weft_polyester');

            // calculated values
            $table->float('warp_ctn_value');
            $table->float('warp_poly_value');
            $table->float('weft_ctn_value');
            $table->float('weft_poly_value');

            $table->float('total_cotton');
            $table->float('total_polyester');

            $table->float('cotton_ratio');
            $table->float('polyester_ratio');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blend_ratios');
    }
};