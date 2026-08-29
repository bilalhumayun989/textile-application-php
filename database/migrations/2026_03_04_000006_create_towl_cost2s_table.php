<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('towl_cost2s', function (Blueprint $table) {
            $table->id();
            // same fields as cost1
            $table->integer('quantity');
            $table->float('warp_rate_lbs');
            $table->float('warp_pct');
            $table->float('weft_rate_lbs');
            $table->float('weft_pct');
            $table->float('pile_rate_lbs')->nullable();
            $table->float('pile_pct')->nullable();
            $table->float('poly_rate_lbs')->nullable();
            $table->float('poly_pct')->nullable();
            $table->float('wastage_pct');
            $table->float('conversion_cost');
            $table->float('bleaching_cost');
            $table->float('dye_cost');
            $table->float('stitch_pack_cost');
            $table->float('wastage2_pct');
            $table->float('custom_clearance');
            $table->float('freight');
            $table->float('exchange_rate');
            $table->float('profit_pct');

            // calculated
            $table->float('base_yarn_cost');
            $table->float('wastage_amount');
            $table->float('grey_cost');
            $table->float('after_bleach_cost');
            $table->float('dyed_cost');
            $table->float('cost_with_stitch');
            $table->float('second_wastage_amount');
            $table->float('per_kg_cost');
            $table->float('custom_per_kg');
            $table->float('freight_per_kg');
            $table->float('total_cost');
            $table->float('price_euro');
            $table->float('final_price');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('towl_cost2s');
    }
};
