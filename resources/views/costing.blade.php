@extends('layouts.app')

@section('title','Fabric Costing')

@section('content')
<div class="container mt-4" style="max-width:1000px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Fabric Costing Calculator</h2>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Calculate Costs</h5>

            <form method="POST" action="{{ route('costing.store') }}">
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Read <span class="text-danger">*</span></label>
                        <input type="number" name="read" value="{{ old('read') }}" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Pick <span class="text-danger">*</span></label>
                        <input type="number" name="pick" value="{{ old('pick') }}" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Warp count <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="warp_count" value="{{ old('warp_count') }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Weft count <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="weft_count" value="{{ old('weft_count') }}" class="form-control" required>
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Width (inches) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="width" value="{{ old('width') }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Yarn warp rate <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="yarn_warp_rate" value="{{ old('yarn_warp_rate') }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Yarn weft rate <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="yarn_weft_rate" value="{{ old('yarn_weft_rate') }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Conversion rate <span class="text-danger">*</span></label>
                        <input type="number" step="0.0001" name="conversion_rate" value="{{ old('conversion_rate') }}" class="form-control" required>
                    </div>
                </div>

                <div class="text-start">
                    <button class="btn btn-primary px-4">Calculate</button>
                </div>

            </form>
        </div>
    </div>

    {{-- <div class="mt-3 d-flex justify-content-between">
        <!-- <a href="{{ route('factor.index') }}" class="btn btn-secondary">← Back Cover Factor</a> -->
        <div>
            <a href="{{ route('run_balance.index') }}" class="btn btn-info">Ledger / Run Balance</a>
            {{-- <a href="{{ route('towlcost1.index') }}" class="btn btn-secondary">Next → Towel Cost 1</a> 
        </div>
    </div> --}}

    @if(session('result'))
        @php $r = session('result'); @endphp
        
        <div class="card shadow-sm border-primary mb-5">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Calculation Results</h5>
            </div>
            <div class="card-body">
                
                <h6 class="text-primary fw-bold text-uppercase border-bottom pb-2 mb-3">Weights</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Warp wt (40m)</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->warp_wt_40m }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Weft wt (40m)</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->weft_wt_40m }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Warp wt 1m</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->warp_weight_1m }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Weft wt 1m</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->weft_weight_1m }}">
                    </div>

                    <div class="col-md-3 mt-3">
                        <label class="form-label text-muted small mb-1">Total wt 1m (lb)</label>
                        <input class="form-control text-center bg-light py-2 fw-bold" readonly value="{{ $r->total_weight_1m_lb }}">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="form-label text-muted small mb-1">Total wt 1m (kg)</label>
                        <input class="form-control text-center bg-light py-2 fw-bold" readonly value="{{ $r->total_weight_1m_kg }}">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="form-label text-muted small mb-1">GSM</label>
                        <input class="form-control text-center bg-light py-2 fw-bold text-primary" readonly value="{{ $r->gsm }}">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="form-label text-muted small mb-1">Sum(Warp:Weft) Ratio</label>
                        <input class="form-control text-center bg-light py-2" readonly value="{{ $r->warp_weft_ratio }}">
                    </div>
                </div>

                <h6 class="text-primary fw-bold text-uppercase border-bottom pb-2 mt-5 mb-3">Pricing & Valuation</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Warp bags</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->warp_bags }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Weft bags</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->weft_bags }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Warp amt/m</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->warp_amount_per_mtr }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Weft amt/m</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->weft_amount_per_mtr }}">
                    </div>

                    <div class="col-md-3 mt-3">
                        <label class="form-label text-muted small mb-1">Conversion/m</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->conversion_per_mtr }}">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="form-label d-block text-dark fw-bold mb-1">Fabric rate/m</label>
                        <input class="form-control text-center fs-5 text-success py-2 fw-bold border-success" readonly value="{{ $r->fabric_rate_per_mtr }}">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="form-label text-muted small mb-1">Cont value</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->cont_value }}">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="form-label text-muted small mb-1">Conv value</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->conv_value }}">
                    </div>

                    <div class="col-md-3 mt-3">
                        <label class="form-label text-muted small mb-1">Yarn value</label>
                        <input class="form-control text-center py-2" readonly value="{{ $r->yarn_value }}">
                    </div>
                    <div class="col-md-3 mt-3">
                        <label class="form-label text-muted small mb-1">Sale tax ({{ empty($r->sale_tax_rate) ? 0 : $r->sale_tax_rate*100 }}%)</label>
                        <input class="form-control text-center text-danger py-2" readonly value="{{ $r->sale_tax_amount }}">
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
@endsection
