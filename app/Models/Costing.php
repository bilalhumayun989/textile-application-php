<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costing extends Model
{
    protected $fillable = [
        'quantity',
        'read',
        'pick',
        'warp_count',
        'weft_count',
        'width',
        'yarn_warp_rate',
        'yarn_weft_rate',
        'conversion_rate',
        // calculated
        'warp_wt_40m',
        'weft_wt_40m',
        'warp_weight_1m',
        'weft_weight_1m',
        'total_weight_1m_lb',
        'total_weight_1m_kg',
        'width_m',
        'gsm',
        'warp_bags',
        'weft_bags',
        'warp_amount_per_mtr',
        'weft_amount_per_mtr',
        'conversion_per_mtr',
        'fabric_rate_per_mtr',
        'cont_value',
        'conv_value',
        'yarn_value',
        'sale_tax_rate',
        'sale_tax_amount',
    ];

    /**
     * Perform the costing calculation using the spreadsheet logic.
     *
     * @param  array<string,mixed>  $input
     * @return array<string,mixed>
     */
    public static function calculate(array $input): array
    {
        $q      = $input['quantity'];
        $read   = $input['read'];
        $pick   = $input['pick'];
        $warp   = $input['warp_count'];
        $weft   = $input['weft_count'];
        $width  = $input['width'];
        $warpRate = $input['yarn_warp_rate'];
        $weftRate = $input['yarn_weft_rate'];
        $convRate = $input['conversion_rate'];

        // constants inferred from provided example
        $warpDenom = 438.0;
        $weftDenom = 598.0;
        $bagsFactor = 16.56; // converts lbs(40m) to "bags" in example
        $lbToKg = 0.453592;

        $width_m = $width * 0.0254; // assume width supplied in inches
        // weight calculations
        $warp_wt_40m  = $warp * (40.0 / $warpDenom);
        $weft_wt_40m  = $weft * (40.0 / $weftDenom);
      $raw_warp = ($read * $width / $warp / 20 * 1.0936) / 40;
    $warp_weight_1m = floor($raw_warp * 10000) / 10000;

    $raw_weft = ($pick * $width / $weft / 20 * 1.0936) / 40;
    $weft_weight_1m = floor($raw_weft * 10000) / 10000;

    // Sync 40m weights
    $warp_wt_40m = $warp_weight_1m * 40;
    $weft_wt_40m = $weft_weight_1m * 40;

    // 2. TOTAL WEIGHTS
    $total_weight_1m_lb = $warp_weight_1m + $weft_weight_1m;
    // Matching =B13 / 2.2046 with 4 decimals
    $total_weight_1m_kg = number_format($total_weight_1m_lb / 2.2046, 4, '.', '');

    // 3. GSM (Matches Blue Box 67)
    $gsm = round((($read / $warp) + ($pick / $weft)) * 25.25, 0);

    // 4. BAGS (Matches Round to 2 decimals)
    $warp_bags = round(($warp_wt_40m / 40 * $q) / 100, 2);
    $weft_bags = round(($weft_wt_40m / 40 * $q) / 100, 2);

    // 5. PRICING (Matches =TRUNC(B11*G5,4))
    // Warp amount per meter
    $raw_warp_amt = $warp_weight_1m * $warpRate;
    $warp_amount_per_mtr = floor($raw_warp_amt * 10000) / 10000;

    // Weft amount per meter
    $raw_weft_amt = $weft_weight_1m * $weftRate;
    $weft_amount_per_mtr = floor($raw_weft_amt * 10000) / 10000;

    // Totals
    $yarn_value_per_mtr = $warp_amount_per_mtr + $weft_amount_per_mtr;
    $conversion_per_mtr = $pick * $convRate;
    $fabric_rate_per_mtr = $yarn_value_per_mtr + $conversion_per_mtr;

    // Final Contract Values
    $cont_value = $fabric_rate_per_mtr * $q;
    $conv_value = $conversion_per_mtr * $q;
    $yarn_value = $yarn_value_per_mtr * $q;

    $sale_tax_rate = 0.17;
    $sale_tax_amount = $cont_value * $sale_tax_rate;

    // For your "Sum(Warp:Weft)" box
    $warp_weft_ratio = $yarn_value_per_mtr;
        
        $read_pick_ratio = $pick > 0 ? $read / $pick : 0;
        return [
            // input
            'quantity' => $q,
            'read' => $read,
            'pick' => $pick,
            'warp_count' => $warp,
            'weft_count' => $weft,
            'width' => $width,
            'yarn_warp_rate' => $warpRate,
            'yarn_weft_rate' => $weftRate,
            'conversion_rate' => $convRate,
            // results
            'warp_wt_40m' => $warp_wt_40m,
            'weft_wt_40m' => $weft_wt_40m,
            'warp_weight_1m' => $warp_weight_1m,
            'weft_weight_1m' => $weft_weight_1m,
            'total_weight_1m_lb' => $total_weight_1m_lb,
            'total_weight_1m_kg' => $total_weight_1m_kg,
            'width_m' => $width_m,
            'gsm' => $gsm,
            'warp_bags' => $warp_bags,
            'weft_bags' => $weft_bags,
            'warp_amount_per_mtr' => $warp_amount_per_mtr,
            'weft_amount_per_mtr' => $weft_amount_per_mtr,
            'conversion_per_mtr' => $conversion_per_mtr,
            'fabric_rate_per_mtr' => $fabric_rate_per_mtr,
            'cont_value' => $cont_value,
            'conv_value' => $conv_value,
            'yarn_value' => $yarn_value,
            'sale_tax_rate' => $sale_tax_rate,
            'sale_tax_amount' => $sale_tax_amount,
            // non‑persistent ratios
            'warp_weft_ratio' => $warp_weft_ratio,
            'read_pick_ratio' => $read_pick_ratio,
        ];
    }
}
