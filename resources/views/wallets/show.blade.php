@extends('layouts.app')

@section('title','Wallet '.$wallet->name)

@section('content')
<style>
    .form-select {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 0.6rem 2.25rem 0.6rem 1rem;
        transition: all 0.2s;
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    .form-select:focus {
        border-color: #7C3AED;
        box-shadow: 0 0 0 0.25rem rgba(124, 58, 237, 0.1);
    }
    .form-control {
        border-radius: 12px;
        padding: 0.6rem 1rem;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
    }
    .form-control:focus {
        border-color: #7C3AED;
        box-shadow: 0 0 0 0.25rem rgba(124, 58, 237, 0.1);
    }
    .btn-save-effect {
        background-color: #7C3AED;
        color: white;
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: bold;
    }
    .btn-save-effect:hover {
        background-color: #6d28d9;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 14px rgba(124, 58, 237, 0.3);
    }
    .card-modern {
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
</style>

<div class="container mt-4" style="max-width:1100px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">
            <i class="fas fa-wallet me-2 text-primary"></i> Wallet: {{ $wallet->name }}
        </h2>
    </div>

    @if(session('status'))
        <div class="alert alert-success mb-4 border-0 shadow-sm" style="border-radius: 12px;">{{ session('status') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4 border-0 shadow-sm" style="border-radius: 12px;">{{ session('error') }}</div>
    @endif

    <div class="card card-modern mb-4">
        <div class="card-body p-4">
            <h5 class="mb-4 fw-bold">
                <i class="fas fa-plus-circle me-2 text-primary"></i> Add Entry
            </h5>

            <form method="POST" action="{{ route('wallets.entry', $wallet->id) }}">
                @csrf

                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted ps-1">Customer / Category</label>
                        <select name="customer_id" class="form-select" required>
                            <option value="other">Personal (Expense)</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted ps-1">Type</label>
                        <select name="type" class="form-select">
                            <option value="rec">Credit (Receive)</option>
                            <option value="pay">Debit (Give)</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted ps-1">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control" placeholder="0.00" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted ps-1">Method</label>
                        <select name="payment_method" class="form-select" id="paymentMethod">
                            <option value="Cash/Check" selected>Cash/Check</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>

                    <div class="col-md-2" id="bankSelectDiv" style="display: none;">
                        <label class="form-label small fw-bold text-danger ps-1">Select Bank *</label>
                        <select name="bank_id" class="form-select border-danger" id="bankSelect">
                            <option value="">Choose Bank</option>
                            @foreach(App\Models\Bank::where('wallet_id', $wallet->id)->get() as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted ps-1">Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Optional notes...">
                    </div>

                    <div class="col-md-12 mt-4 text-end">
                        <button class="btn btn-save-effect px-5 py-2">
                            <i class="fas fa-save me-2"></i> Save Transaction
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('paymentMethod').addEventListener('change', function() {
            const bankSelectDiv = document.getElementById('bankSelectDiv');
            const bankSelect = document.getElementById('bankSelect');
            if (this.value === 'Bank') {
                bankSelectDiv.style.display = 'block';
                bankSelect.required = true;
            } else {
                bankSelectDiv.style.display = 'none';
                bankSelect.required = false;
            }
        });
    </script>

</div>
@endsection