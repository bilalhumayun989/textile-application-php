<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TowlCost1 extends Model
{
    protected $fillable = [
        'quantity',
        'warp_rate_lbs',
        'warp_pct',
        'weft_rate_lbs',
        'weft_pct',
        'pile_rate_lbs',
        'pile_pct',
        'poly_rate_lbs',
        'poly_pct',
        'wastage_pct',
        'conversion_cost',
        'bleaching_cost',
        'dye_cost',
        'stitch_pack_cost',
        'wastage2_pct',
        'custom_clearance',
        'freight',
        'exchange_rate',
        'profit_pct',
        'base_yarn_cost',
        'wastage_amount',
        'grey_cost',
        'after_bleach_cost',
        'dyed_cost',
        'cost_with_stitch',
        'second_wastage_amount',
        'per_kg_cost',
        'custom_per_kg',
        'freight_per_kg',
        'total_cost',
        'price_euro',
        'final_price',
    ];

    public static function calculate(array $i): array
    {
        $q = $i['quantity'];
        $warpRate = $i['warp_rate_lbs'];
        $warpPct = $i['warp_pct'];
        $weftRate = $i['weft_rate_lbs'];
        $weftPct = $i['weft_pct'];
        $pileRate = $i['pile_rate_lbs'] ?? 0;
        $pilePct = $i['pile_pct'] ?? 0;
        $polyRate = $i['poly_rate_lbs'] ?? 0;
        $polyPct = $i['poly_pct'] ?? 0;
        $wastagePct = $i['wastage_pct'];
        $conversionCost = $i['conversion_cost'];
        $bleachCost = $i['bleaching_cost'];
        $dyeCost = $i['dye_cost'];
        $stitchCost = $i['stitch_pack_cost'];
        $wastage2Pct = $i['wastage2_pct'];
        $custom = $i['custom_clearance'];
        $freight = $i['freight'];
        $exchange = $i['exchange_rate'];
        $profitPct = $i['profit_pct'];

        $factor = 2.20462;
        $warpCost = ($warpRate * $factor) * ($warpPct/100);
        $weftCost = ($weftRate * $factor) * ($weftPct/100);
        $pileCost = ($pileRate * $factor) * ($pilePct/100);
        $polyCost = ($polyRate * $factor) * ($polyPct/100);

        $base = $warpCost + $weftCost + $pileCost + $polyCost;
        $wastageAmt = $base * ($wastagePct/100);
        $grey = $base + $wastageAmt + $conversionCost;
        $afterBleach = $grey + $bleachCost;
        $dyed = $afterBleach + $dyeCost;
        $costStitch = $dyed + $stitchCost;
        $wastage2Amt = $costStitch * ($wastage2Pct/100);
        $perKg = $costStitch + $wastage2Amt;
        $customPerKg = $q>0 ? $custom / $q : 0;
        $freightPerKg = $q>0 ? $freight / $q : 0;
        $total = $perKg + $customPerKg + $freightPerKg;
        $priceEur = $exchange>0 ? $total / $exchange : 0;
        $final = $priceEur * (1 + $profitPct/100);

        return array_merge($i, [
            'base_yarn_cost' => $base,
            'wastage_amount' => $wastageAmt,
            'grey_cost' => $grey,
            'after_bleach_cost' => $afterBleach,
            'dyed_cost' => $dyed,
            'cost_with_stitch' => $costStitch,
            'second_wastage_amount' => $wastage2Amt,
            'per_kg_cost' => $perKg,
            'custom_per_kg' => $customPerKg,
            'freight_per_kg' => $freightPerKg,
            'total_cost' => $total,
            'price_euro' => $priceEur,
            'final_price' => $final,
        ]);
    }
}
