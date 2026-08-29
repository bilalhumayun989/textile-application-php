<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TowlCost2 extends Model
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
        // reuse same calculation as TowlCost1
        return TowlCost1::calculate($i);
    }
}
