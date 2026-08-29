<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costings', function (Blueprint $table) {
            $table->id();

            // user inputs
            $table->integer('quantity');
            $table->integer('read');
            $table->integer('pick');
            $table->float('warp_count');
            $table->float('weft_count');
            $table->float('width');
            $table->float('yarn_warp_rate');
            $table->float('yarn_weft_rate');
            $table->float('conversion_rate');

            // calculated fields
            $table->float('warp_wt_40m');
            $table->float('weft_wt_40m');
            $table->float('warp_weight_1m');
            $table->float('weft_weight_1m');
            $table->float('total_weight_1m_lb');
            $table->float('total_weight_1m_kg');
            $table->float('width_m');
            $table->float('gsm');

            $table->float('warp_bags');
            $table->float('weft_bags');
            $table->float('warp_amount_per_mtr');
            $table->float('weft_amount_per_mtr');
            $table->float('conversion_per_mtr');
            $table->float('fabric_rate_per_mtr');

            $table->float('cont_value');
            $table->float('conv_value');
            $table->float('yarn_value');
            $table->float('sale_tax_rate');
            $table->float('sale_tax_amount');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costings');
    }
};
