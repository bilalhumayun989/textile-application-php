@extends('layouts.app')

@section('title','Cover Factor Calculator')

@section('content')
<div class="container mt-4" style="max-width:1000px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Cover Factor Calculator</h2>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Calculate Cover Factor</h5>

            <form method="POST" action="{{ route('factor.store') }}">
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

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Warp Count <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="warp_count" value="{{ old('warp_count') }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Weft Count <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="weft_count" value="{{ old('weft_count') }}" class="form-control" required>
                    </div>
                </div>

                <div class="text-start">
                    <button class="btn btn-primary px-4">Calculate</button>
                </div>

            </form>
        </div>
    </div>
@if(session('result'))
    @php $r = session('result'); @endphp
    
    <div class="card shadow-sm border-primary mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Calculation Results</h5>
        </div>
        <div class="card-body">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 border-end">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label text-muted small text-uppercase">Warp Term</label>
                            <input type="text" readonly class="form-control text-center py-2 fw-bold" value="{{ number_format($r->warp_term,2) }}">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label text-muted small text-uppercase">Weft Term</label>
                            <input type="text" readonly class="form-control text-center py-2 fw-bold" value="{{ number_format($r->weft_term,2) }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 text-center">
                    <label class="form-label d-block text-primary text-uppercase fw-bold mb-2 fs-5">Cover Factor</label>
                    <input type="text" readonly class="form-control text-center fs-3 py-3 text-success fw-bold border-success" value="{{ number_format($r->cover_factor,2) }}">
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card shadow-sm mb-5">
    <div class="card-body">
        <h5 class="mb-3">Weave Types &amp; Recommended RPM</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Weave</th>
                        <th>RPM per Loom</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1/1 Plain Weave (up to 28‑30)</td>
                        <td>Power 100</td>
                    </tr>
                    <tr>
                        <td>2/1 Twill Weave (up to 30‑36)</td>
                        <td>Auto 100</td>
                    </tr>
                    <tr>
                        <td>3/1 Drill Weave (up to 42)</td>
                        <td>Sulzer 225‑280</td>
                    </tr>
                    <tr>
                        <td>4/1 Satin Weave (up to 47)</td>
                        <td>Air Jet 650‑1200</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
@endsection

