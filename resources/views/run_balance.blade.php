@extends('layouts.app')

@section('title','Customer Running Balance')

@section('content')

<div class="container mt-4" style="max-width:1000px;">

    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">
            <i class="fas fa-book-open me-2 text-primary"></i> Customer Ledger
        </h2>
    </div>

    <!-- Layout Summary (If selected) -->
    @if(isset($selected) && $selected)
        @php
            $currentCustomer = $customers->find($selected);
            $totalDebit = $transactions->sum('debit');
            $totalCredit = $transactions->sum('credit');
            $finalBalance = $transactions->last()?->balance ?? 0;
        @endphp
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm bg-white">
                    <div class="card-body p-3">
                        <div class="text-uppercase small fw-bold text-muted mb-1">Total Sales (Debit)</div>
                        <h4 class="mb-0 text-danger fw-bold">{{ number_format($totalDebit, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm bg-white">
                    <div class="card-body p-3">
                        <div class="text-uppercase small fw-bold text-muted mb-1">Total Received (Credit)</div>
                        <h4 class="mb-0 text-success fw-bold">{{ number_format($totalCredit, 2) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm {{ $finalBalance >= 0 ? 'bg-primary-subtle border-primary' : 'bg-danger-subtle border-danger' }}">
                    <div class="card-body p-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase small fw-bold text-muted mb-1">Current Net Balance</div>
                            <h3 class="mb-0 {{ $finalBalance >= 0 ? 'text-primary' : 'text-danger' }} fw-bold">
                                {{ number_format(abs($finalBalance), 2) }}
                                <small class="fs-6 opacity-75">{{ $finalBalance >= 0 ? '(Receivable)' : '(Payable)' }}</small>
                            </h3>
                        </div>
                        <i class="fas {{ $finalBalance >= 0 ? 'fa-arrow-trend-up text-primary' : 'fa-arrow-trend-down text-danger' }} fa-2x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Top Buttons -->
    {{-- <div class="d-flex justify-content-start align-items-center mb-5 mt-5" style="gap: 2rem;">
        <div>
            <!-- <a href="{{ route('costing.index') }}" class="btn btn-secondary">← Back Costing</a> -->
        </div>
        <div>
            <a href="{{ route('run_balance.customer_create') }}" class="btn btn-primary">
                Add Customer
            </a>
        </div>
        <div>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal">
                Delete Customer
            </button>
        </div>
    </div> --}}

    @if(session('status'))
        <div class="alert alert-success mb-4 border-0 shadow-sm" style="border-radius: 12px;">{{ session('status') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4 border-0 shadow-sm" style="border-radius: 12px;">{{ session('error') }}</div>
    @endif
    @if(session('delete_error'))
        <div class="alert alert-danger mb-4 border-0 shadow-sm" style="border-radius: 12px;">{{ session('delete_error') }}</div>
    @endif



    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary-subtle border-0 py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2"></i> Select Customer Ledger</h5>
        </div>
        <div class="card-body">
            <!-- Customer Selector Form -->
            <form method="GET" action="{{ route('run_balance.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-9">
                        <label class="form-label small fw-bold text-muted">Customer Account</label>
                        <select name="customer_id" class="form-select form-control" required>
                            <option value="">-- Choose a customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ isset($selected) && $selected == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button class="btn btn-primary w-100 fw-bold">
                            <i class="fas fa-search me-2"></i> Show Ledger
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($selected) && $selected)
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-light border-0 py-3">
                <h5 class="mb-0 fw-bold text-muted"><i class="fas fa-plus-circle me-2"></i> Add New Transaction</h5>
            </div>
            <div class="card-body">
                <!-- Add Transaction Form -->
                <form method="POST" action="{{ route('run_balance.store') }}">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $selected }}">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Transaction Type</label>
                            <select name="type" id="transactionType" class="form-select" required onchange="toggleDiscountUI()">
                                <option value="opening_balance">Opening Balance</option>
                                <option value="deposit">Customer Deposit</option>
                                <option value="sale">Product Sale (Invoice)</option>
                                <option value="payment_received">Payment Received</option>
                                <option value="discount">Discount / Adjustment (%)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Amount</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0" id="currencyPrefix" style="font-size: 0.8rem;">Rs</span>
                                <input type="number" step="0.01" name="amount" id="amountInput" class="form-control border-start-0" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Method</label>
                            <select name="payment_method" id="paymentMethod" class="form-select" onchange="toggleBankSelection()">
                                <option value="Cash/Check" selected>Cash/Check</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-1">
                        <div class="col-md-4" id="bankSelectionWrapper" style="display: none;">
                            <label class="form-label small fw-bold text-danger">Select Bank *</label>
                            <select name="bank_id" id="bankSelect" class="form-select border-danger">
                                <option value="">-- Choose Bank --</option>
                                @foreach($banks as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8" id="notesWrapper">
                            <label class="form-label small fw-bold">Description</label>
                            <input type="text" name="description" class="form-control" placeholder="Optional details...">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button class="btn btn-success fw-bold text-white border-0 px-5 py-2 shadow-sm" style="background-color: var(--primary-purple); border-radius: 12px;">
                            <i class="fas fa-save me-2"></i> Save Transaction
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-list-ul me-2 text-primary"></i> Transaction History</h5>
                <span class="badge bg-light text-dark border">{{ $transactions->count() }} Entries</span>
            </div>
            <div class="card-body p-0">
                <!-- Transactions Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Date</th>
                                <th>Type</th>
                                <th class="text-danger">Debit (Sale)</th>
                                <th class="text-success">Credit (Rec)</th>
                                <th>Balance</th>
                                <th>Method</th>
                                <th class="pe-3">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
                                <tr>
                                    <td class="ps-3 small fw-bold text-muted">{{ $tx->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border-0 text-uppercase" style="font-size: 0.65rem;">
                                            {{ str_replace('_', ' ', $tx->type) }}
                                        </span>
                                    </td>
                                    <td class="text-danger fw-bold">{{ $tx->debit > 0 ? number_format($tx->debit, 2) : '-' }}</td>
                                    <td class="text-success fw-bold">{{ $tx->credit > 0 ? number_format($tx->credit, 2) : '-' }}</td>
                                    <td>
                                        <div class="fw-bold {{ $tx->balance >= 0 ? 'text-primary' : 'text-danger' }}">
                                            {{ number_format(abs($tx->balance), 2) }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.7rem;">
                                            {{ $tx->balance >= 0 ? 'Receivable' : 'Payable' }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info border-0">{{ $tx->payment_method ?? 'Amount' }}</span>
                                    </td>
                                    <td class="pe-3 small text-secondary">{{ $tx->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-3 opacity-25"></i>
                                        <p class="mb-0">No transactions yet</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

</div>

<!-- ===== Delete Customer Modal ===== -->
<div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('run_balance.delete_customer') }}" id="deleteCustomerForm">
                @csrf
                @method('DELETE')

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCustomerModalLabel">Delete Customer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted mb-3">This will permanently delete the customer and all their transactions. Admin credentials are required.</p>

                    <!-- Customer selector -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Customer to Delete <span class="text-danger">*</span></label>
                        <select name="customer_id" id="deleteCustomerId" class="form-control" required>
                            <option value="">-- Select customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Admin Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Admin Name <span class="text-danger">*</span></label>
                        <input type="text" name="admin_name" class="form-control" placeholder="Enter admin name" required autocomplete="off">
                    </div>

                    <!-- Admin Password -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Admin Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="admin_password" id="adminPasswordInput" class="form-control" placeholder="Enter admin password" required autocomplete="off">
                            {{-- <button class="btn btn-outline-secondary" type="button" id="toggleAdminPassword">
                                Show
                            </button> --}}
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('toggleAdminPassword').addEventListener('click', function () {
        const input = document.getElementById('adminPasswordInput');
        if (input.type === 'password') {
            input.type = 'text';
            this.textContent = ' Hide';
        } else {
            input.type = 'password';
            this.textContent = ' Show';
        }
    });

    function toggleDiscountUI() {
        const type = document.getElementById('transactionType').value;
        const prefix = document.getElementById('currencyPrefix');
        const amountInput = document.getElementById('amountInput');
        
        if (type === 'discount') {
            prefix.textContent = '%';
            amountInput.placeholder = "e.g. 10";
        } else {
            prefix.textContent = 'Rs';
            amountInput.placeholder = "0.00";
        }
    }

    function toggleBankSelection() {
        const method = document.getElementById('paymentMethod').value;
        const bankWrapper = document.getElementById('bankSelectionWrapper');
        const bankSelect = document.getElementById('bankSelect');
        const notesWrapper = document.getElementById('notesWrapper');
        
        if (method === 'Bank') {
            bankWrapper.style.display = 'block';
            bankSelect.required = true;
            notesWrapper.className = 'col-md-2';
        } else {
            bankWrapper.style.display = 'none';
            bankSelect.required = false;
            notesWrapper.className = 'col-md-4'; // Expand notes if bank selection is hidden
        }
    }
</script>

@endsection

