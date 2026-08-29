@extends('layouts.app')

@section('title','Towel Cost 2')

@section('content')
<div class="container mt-5">
    <h2>Towel Cost Calculator 2</h2>
    <form method="POST" action="{{ route('towlcost2.store') }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Rate (PKR/LBS)</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Warp</td>
                    <td><input type="number" step="0.01" name="warp_rate_lbs" value="{{ old('warp_rate_lbs') }}" class="form-control" required></td>
                    <td><input type="number" step="0.01" name="warp_pct" value="{{ old('warp_pct') }}" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Weft</td>
                    <td><input type="number" step="0.01" name="weft_rate_lbs" value="{{ old('weft_rate_lbs') }}" class="form-control" required></td>
                    <td><input type="number" step="0.01" name="weft_pct" value="{{ old('weft_pct') }}" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Pile</td>
                    <td><input type="number" step="0.01" name="pile_rate_lbs" value="{{ old('pile_rate_lbs') }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="pile_pct" value="{{ old('pile_pct') }}" class="form-control"></td>
                </tr>
                <tr>
                    <td>Weft Polyester</td>
                    <td><input type="number" step="0.01" name="poly_rate_lbs" value="{{ old('poly_rate_lbs') }}" class="form-control"></td>
                    <td><input type="number" step="0.01" name="poly_pct" value="{{ old('poly_pct') }}" class="form-control"></td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-2"><label>Quantity</label><input type="number" step="1" name="quantity" value="{{ old('quantity') }}" class="form-control" required></div>
            <div class="col-md-2"><label>Wastage %</label><input type="number" step="0.01" name="wastage_pct" value="{{ old('wastage_pct') }}" class="form-control" required></div>
            <div class="col-md-2"><label>Conversion</label><input type="number" step="0.01" name="conversion_cost" value="{{ old('conversion_cost') }}" class="form-control" required></div>
            <div class="col-md-2"><label>Bleaching</label><input type="number" step="0.01" name="bleaching_cost" value="{{ old('bleaching_cost') }}" class="form-control" required></div>
            <div class="col-md-2"><label>Dyed towel cost</label><input type="number" step="0.01" name="dye_cost" value="{{ old('dye_cost') }}" class="form-control" required></div>
            <div class="col-md-2"><label>Stitching+Packing</label><input type="number" step="0.01" name="stitch_pack_cost" value="{{ old('stitch_pack_cost') }}" class="form-control" required></div>
        </div>

        <div class="row mt-2">
            <div class="col-md-2"><label>Wastage % (2)</label><input type="number" step="0.01" name="wastage2_pct" value="{{ old('wastage2_pct') }}" class="form-control" required></div>
            <div class="col-md-2"><label>Custom Clearance</label><input type="number" step="0.01" name="custom_clearance" value="{{ old('custom_clearance') }}" class="form-control" required></div>
            <div class="col-md-2"><label>Freight (USD 1000)</label><input type="number" step="0.01" name="freight" value="{{ old('freight') }}" class="form-control" required></div>
            <div class="col-md-2"><label>Exchange Rate</label><input type="number" step="0.01" name="exchange_rate" value="{{ old('exchange_rate') }}" class="form-control" required></div>
            <div class="col-md-2"><label>Profit %</label><input type="number" step="0.01" name="profit_pct" value="{{ old('profit_pct') }}" class="form-control" required></div>
        </div>

        <br>
        <button class="btn btn-primary">Calculate</button>
    </form>
    <div class="mt-3 d-flex justify-content-between">
        <a href="{{ route('towlcost1.index') }}" class="btn btn-secondary">← Back Towel Cost 1</a>
        <div></div>
    </div>

    @if(session('result'))
        <hr>
        <h3>Results</h3>
        @php $r = session('result'); @endphp
        <div class="row">
            <div class="col-md-3"><label>Base yarn cost</label><input class="form-control result-input" readonly value="{{ number_format($r->base_yarn_cost,2) }}"></div>
            <div class="col-md-3"><label>Wastage amt</label><input class="form-control result-input" readonly value="{{ number_format($r->wastage_amount,2) }}"></div>
            <div class="col-md-3"><label>Grey cost</label><input class="form-control result-input" readonly value="{{ number_format($r->grey_cost,2) }}"></div>
            <div class="col-md-3"><label>After bleach</label><input class="form-control result-input" readonly value="{{ number_format($r->after_bleach_cost,2) }}"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"><label>Dyed cost</label><input class="form-control result-input" readonly value="{{ number_format($r->dyed_cost,2) }}"></div>
            <div class="col-md-3"><label>Cost with stitch</label><input class="form-control result-input" readonly value="{{ number_format($r->cost_with_stitch,2) }}"></div>
            <div class="col-md-3"><label>2nd wastage amt</label><input class="form-control result-input" readonly value="{{ number_format($r->second_wastage_amount,2) }}"></div>
            <div class="col-md-3"><label>Per kg cost</label><input class="form-control result-input" readonly value="{{ number_format($r->per_kg_cost,2) }}"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"><label>Custom/kg</label><input class="form-control result-input" readonly value="{{ number_format($r->custom_per_kg,2) }}"></div>
            <div class="col-md-3"><label>Freight/kg</label><input class="form-control result-input" readonly value="{{ number_format($r->freight_per_kg,2) }}"></div>
            <div class="col-md-3"><label>Total cost</label><input class="form-control result-input" readonly value="{{ number_format($r->total_cost,2) }}"></div>
            <div class="col-md-3"><label>Price (€)</label><input class="form-control result-input" readonly value="{{ number_format($r->price_euro,2) }}"></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"><label>Final price (€)</label><input class="form-control result-input" readonly value="{{ number_format($r->final_price,2) }}"></div>
        </div>
    @endif
</div>
@endsection
