@extends('layouts.app')

@section('title','Add Wallet')

@section('content')
<div class="container mt-5">
    <h2>Add Wallet</h2>

    <form method="POST" action="{{ route('wallets.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
        </div>

        <button class="btn btn-primary">Create Wallet</button>
         <!-- <a href="{{ route('wallets.index') }}" class="btn btn-secondary">Back</a> -->
    </form>
</div>
@endsection