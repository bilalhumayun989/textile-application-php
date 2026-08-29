<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TowlCost2;

class TowlCost2Controller extends Controller
{
    public function index()
    {
        return view('towlcost2');
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'quantity' => 'required|numeric|min:0',
            'warp_rate_lbs' => 'required|numeric|min:0',
            'warp_pct' => 'required|numeric|min:0',
            'weft_rate_lbs' => 'required|numeric|min:0',
            'weft_pct' => 'required|numeric|min:0',
            'pile_rate_lbs' => 'nullable|numeric|min:0',
            'pile_pct' => 'nullable|numeric|min:0',
            'poly_rate_lbs' => 'nullable|numeric|min:0',
            'poly_pct' => 'nullable|numeric|min:0',
            'wastage_pct' => 'required|numeric|min:0',
            'conversion_cost' => 'required|numeric|min:0',
            'bleaching_cost' => 'required|numeric|min:0',
            'dye_cost' => 'required|numeric|min:0',
            'stitch_pack_cost' => 'required|numeric|min:0',
            'wastage2_pct' => 'required|numeric|min:0',
            'custom_clearance' => 'required|numeric|min:0',
            'freight' => 'required|numeric|min:0',
            'exchange_rate' => 'required|numeric|min:0',
            'profit_pct' => 'required|numeric|min:0',
        ]);

        $attributes = TowlCost2::calculate($input);
        $result = TowlCost2::create($attributes);

        return redirect()->route('towlcost2.index')
            ->withInput()
            ->with('result', $result);
    }
}
