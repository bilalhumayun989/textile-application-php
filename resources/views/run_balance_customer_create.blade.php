@extends('layouts.app')

@section('title','Add Customer')

@section('content')
<div class="container mt-4" style="max-width:1000px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Add Customer</h2>
        <!-- <a href="{{ route('run_balance.index') }}" class="btn btn-secondary">Back to Ledger</a> -->
    </div>



    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Customer Details</h5>

    <form method="POST" action="{{ route('run_balance.add_customer') }}">
        @csrf

        <div class="row">
            <div class="col-md-3">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="col-md-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="col-md-3">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label>Contact info</label>
                <input type="text" name="contact_info" value="{{ old('contact_info') }}" class="form-control">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6 mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-control">
            </div>
            
            <div class="col-md-6 d-flex flex-column justify-content-end mb-3">
                <button class="btn w-100 text-white" style="background-color:#7C3AED;">
                    Save Customer
                </button>
            </div>
        </div>

    </form>
    </div>
    </div>

</div>
@endsection
