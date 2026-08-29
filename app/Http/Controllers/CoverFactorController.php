<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoverFactor;

class CoverFactorController extends Controller
{
    /**
     * Show the cover factor form.
     */
    public function index()
    {
        return view('factor');
    }

    /**
     * Validate, calculate and persist a cover factor entry.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'ends' => 'required|numeric|min:0',
            'picks' => 'required|numeric|min:0',
            'warp_count' => 'required|numeric|min:0',
            'weft_count' => 'required|numeric|min:0',
        ]);

        $attributes = CoverFactor::calculate($input);
        $result = CoverFactor::create($attributes);

        return redirect()
            ->route('factor.index')
            ->withInput()
            ->with('result', $result);
    }
}
