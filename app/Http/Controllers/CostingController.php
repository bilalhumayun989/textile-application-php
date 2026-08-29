<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costing;

class CostingController extends Controller
{
    /**
     * Display costing form.
     */
    public function index()
    {
        return view('costing');
    }

    /**
     * Validate input, run calculation, persist and return back with results.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'quantity' => 'required|numeric|min:0',
            'read' => 'required|numeric|min:0',
            'pick' => 'required|numeric|min:0',
            'warp_count' => 'required|numeric|min:0',
            'weft_count' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'yarn_warp_rate' => 'required|numeric|min:0',
            'yarn_weft_rate' => 'required|numeric|min:0',
            'conversion_rate' => 'required|numeric|min:0',
        ]);

        $attributes = Costing::calculate($input);

        // the model doesn't have database columns for the computed ratios,
        // so only persist keys that are fillable on the model. any extra
        // fields such as warp_weft_ratio/read_pick_ratio are dropped.
        $persist = array_intersect_key(
            $attributes,
            array_flip((new Costing)->getFillable())
        );

        $saved = Costing::create($persist);

        // merge saved model's id/timestamps back with the full attribute set so
        // the view can still see the ratios and other computed values.
        $result = (object) array_merge(
            $attributes,
            ['id' => $saved->id, 'created_at' => $saved->created_at, 'updated_at' => $saved->updated_at]
        );

        return redirect()
            ->route('costing.index')
            ->withInput()
            ->with('result', $result);
    }
}
