@extends('layouts.app')

@section('title','Blend Ratio Calculator')

@section('content')
<div class="container mt-4" style="max-width:1000px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Fabric Blend Ratio</h2>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Calculate Blend</h5>

            <form method="POST" action="{{ route('blend.store') }}">
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Ends <span class="text-danger">*</span></label>
                        <input type="number" name="ends" value="{{ old('ends') }}" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Picks <span class="text-danger">*</span></label>
                        <input type="number" name="picks" value="{{ old('picks') }}" class="form-control" required>
                    </div>
                </div>

                <hr class="mb-4">

                <h6 class="fw-bold mb-3">Warp</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Warp Cotton %</label>
                        <input type="number" step="0.01" name="warp_cotton" value="{{ old('warp_cotton') }}" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Warp Polyester %</label>
                        <input type="number" step="0.01" name="warp_polyester" value="{{ old('warp_polyester') }}" class="form-control" required>
                    </div>
                </div>

                <hr class="mb-4">

                <h6 class="fw-bold mb-3">Weft</h6>
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Weft Cotton %</label>
                        <input type="number" step="0.01" name="weft_cotton" value="{{ old('weft_cotton') }}" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Weft Polyester %</label>
                        <input type="number" step="0.01" name="weft_polyester" value="{{ old('weft_polyester') }}" class="form-control" required>
                    </div>
                </div>

                <div class="text-start">
                    <button class="btn btn-primary px-4">Calculate</button>
                </div>

            </form>
        </div>
    </div>

<div class="mt-3 d-flex justify-content-between">
    {{-- <div></div>
    <a href="{{ route('factor.index') }}" class="btn btn-secondary">Next → Cover Factor</a>
</div> --}}

@if(session('result'))
    @php
        $r = session('result');
    @endphp

    <div class="card shadow-sm border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Calculation Results</h5>
        </div>
        <div class="card-body">
            
            <div class="row mb-4 text-center">
                <div class="col-6 col-md-3 mb-3">
                    <label class="form-label text-muted small text-uppercase">Warp Cotton</label>
                    <input type="text" readonly class="form-control text-center py-2 fw-bold" value="{{ number_format($r->warp_ctn_value,2) }}">
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <label class="form-label text-muted small text-uppercase">Warp Poly</label>
                    <input type="text" readonly class="form-control text-center py-2 fw-bold" value="{{ number_format($r->warp_poly_value,2) }}">
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <label class="form-label text-muted small text-uppercase">Weft Cotton</label>
                    <input type="text" readonly class="form-control text-center py-2 fw-bold" value="{{ number_format($r->weft_ctn_value,2) }}">
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <label class="form-label text-muted small text-uppercase">Weft Poly</label>
                    <input type="text" readonly class="form-control text-center py-2 fw-bold" value="{{ number_format($r->weft_poly_value,2) }}">
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center text-center">
                <!-- Totals -->
                <div class="col-md-6 border-end">
                    <h6 class="text-muted text-uppercase mb-3">Raw Totals</h6>
                    <div class="d-flex justify-content-around">
                        <div>
                            <span class="d-block form-label small mb-1">Total Cotton</span>
                            <span class="fs-5 fw-bold">{{ number_format($r->total_cotton,2) }}</span>
                        </div>
                        <div>
                            <span class="d-block form-label small mb-1">Total Polyester</span>
                            <span class="fs-5 fw-bold">{{ number_format($r->total_polyester,2) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Final Ratio -->
                <div class="col-md-6">
                    <h5 class="text-primary text-uppercase mb-3">Final Blend Ratio</h5>
                    <div class="d-flex justify-content-around align-items-end">
                        <div class="text-center">
                            <label class="form-label d-block mb-1 text-dark fw-bold">Cotton</label>
                            <input type="text" readonly class="form-control text-center fs-5 py-2 text-success fw-bold" value="{{ number_format($r->cotton_ratio,2) }} %" style="width: 120px;">
                        </div>
                        <div class="fs-4 text-muted mx-2 mb-2">:</div>
                        <div class="text-center">
                            <label class="form-label d-block mb-1 text-dark fw-bold">Polyester</label>
                            <input type="text" readonly class="form-control text-center fs-5 py-2 text-primary fw-bold" value="{{ number_format($r->polyester_ratio,2) }} %" style="width: 120px;">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endif

</div>
@endsection
