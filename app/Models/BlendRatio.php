<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlendRatio extends Model
{
    /**
     * Mass‑assignable fields. The payload stored in the database includes
     * inputs plus the computed values.  Keeping the list explicit helps
     * avoid unexpected data injection.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'ends',
        'picks',
        'warp_cotton',
        'warp_polyester',
        'weft_cotton',
        'weft_polyester',
        'warp_ctn_value',
        'warp_poly_value',
        'weft_ctn_value',
        'weft_poly_value',
        'total_cotton',
        'total_polyester',
        'cotton_ratio',
        'polyester_ratio',
    ];

    /**
     * Perform the blend calculations and return an array suitable for
     * creating a model or returning to the view. Accepts the raw request
     * data so the controller stays thin.
     *
     * @param  array<string,mixed>  $input
     * @return array<string,mixed>
     */
    public static function calculate(array $input): array
    {
        $ends = $input['ends'];
        $picks = $input['picks'];

        $warpCotton = $input['warp_cotton'];
        $warpPoly = $input['warp_polyester'];

        $weftCotton = $input['weft_cotton'];
        $weftPoly = $input['weft_polyester'];

        $warp_ctn_value  = $ends * ($warpCotton / 100);
        $warp_poly_value = $ends * ($warpPoly / 100);

        $weft_ctn_value  = $picks * ($weftCotton / 100);
        $weft_poly_value = $picks * ($weftPoly / 100);

        $total_cotton    = $warp_ctn_value + $weft_ctn_value;
        $total_polyester = $warp_poly_value + $weft_poly_value;

        $total_threads = $ends + $picks;

        $cotton_ratio = $total_threads > 0
            ? ($total_cotton / $total_threads) * 100
            : 0;

        $poly_ratio = $total_threads > 0
            ? ($total_polyester / $total_threads) * 100
            : 0;

        return [
            'ends' => $ends,
            'picks' => $picks,
            'warp_cotton' => $warpCotton,
            'warp_polyester' => $warpPoly,
            'weft_cotton' => $weftCotton,
            'weft_polyester' => $weftPoly,
            'warp_ctn_value' => $warp_ctn_value,
            'warp_poly_value' => $warp_poly_value,
            'weft_ctn_value' => $weft_ctn_value,
            'weft_poly_value' => $weft_poly_value,
            'total_cotton' => $total_cotton,
            'total_polyester' => $total_polyester,
            'cotton_ratio' => $cotton_ratio,
            'polyester_ratio' => $poly_ratio,
        ];
    }
}
