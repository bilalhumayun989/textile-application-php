<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlendRatio;

class BlendRatioController extends Controller
{
    /**
     * Show the calculator form.
     */
    public function index()
    {
        return view('blend');
    }

    /**
     * Handle an incoming submission, validate, calculate and persist.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'ends' => 'required|numeric|min:0',
            'picks' => 'required|numeric|min:0',
            'warp_cotton' => 'required|numeric|min:0',
            'warp_polyester' => 'required|numeric|min:0',
            'weft_cotton' => 'required|numeric|min:0',
            'weft_polyester' => 'required|numeric|min:0',
        ]);

        // perform the core calculation in the model for reuse and testing
        $attributes = BlendRatio::calculate($input);
        $result = BlendRatio::create($attributes);

        // redirect to the form with the computed result attached
        // include the old input so that form fields remain populated
        return redirect()
            ->route('blend.index')
            ->withInput()
            ->with('result', $result);
    }
}