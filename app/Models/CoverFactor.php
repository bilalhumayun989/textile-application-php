<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoverFactor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'ends',
        'picks',
        'warp_count',
        'weft_count',
        'warp_term',
        'weft_term',
        'cover_factor',
    ];

    /**
     * Perform the cover factor calculation.
     *
     * @param  array<string,mixed>  $input
     * @return array<string,mixed>
     */
    public static function calculate(array $input): array
    {
        $ends = $input['ends'];
        $picks = $input['picks'];
        $warp = $input['warp_count'];
        $weft = $input['weft_count'];

        $warp_term = $warp > 0 ? $ends / sqrt($warp) : 0;
        $weft_term = $weft > 0 ? $picks / sqrt($weft) : 0;
        $cover = $warp_term + $weft_term;

        return [
            'ends' => $ends,
            'picks' => $picks,
            'warp_count' => $warp,
            'weft_count' => $weft,
            'warp_term' => $warp_term,
            'weft_term' => $weft_term,
            'cover_factor' => $cover,
        ];
    }
}
