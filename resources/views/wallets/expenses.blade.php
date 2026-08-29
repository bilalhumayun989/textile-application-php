@extends('layouts.app')

@section('title', 'Diary - ' . $wallet->name)
<style>
    .diary-header {
        background: linear-gradient(135deg, #c9adf8ff 0%, #b588fdff 100%);
        padding: 2.5rem 2rem;
        border-radius: 24px;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(109, 40, 217, 0.15);
    }
    .diary-stat-card {
        transition: transform 0.3s ease;
    }
    .diary-stat-card:hover {
        transform: translateY(-5px);
    }
</style>

@section('content')
<div class="container mt-4" style="max-width:1100px;">
    
    <div class="diary-header d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div>
            <h2 class="mb-1 fw-bold">
                <i class="fas fa-book-open me-2"></i> Diary
            </h2>
            <p class="mb-0 opacity-75">Transaction history for {{ $wallet->name }}</p>
        </div>
        
        <div class="d-flex gap-3 mt-3 mt-md-0">
            <!-- Filter Dropdown -->
            <div class="dropdown">
                <button class="btn btn-light rounded-pill px-4 fw-bold shadow-sm dropdown-toggle text-primary border-0" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="me-2"></i>
                    @if($view === 'personal')
                        <i class="fas fa-user me-1"></i> Personal Only
                    @elseif($view === 'customer')
                        <i class="fas fa-users me-1"></i> Customer Only
                    @else
                        <i class="fas fa-list-ul me-1"></i> All Records
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2" aria-labelledby="filterDropdown">
                    <li>
                        <a class="dropdown-item rounded-3 py-2 {{ $view === 'all' ? 'active bg-primary' : '' }}" href="{{ route('wallets.expenses', ['wallet' => $wallet->id, 'view' => 'all']) }}">
                            <i class="fas fa-list-ul me-2"></i> All Records
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item rounded-3 py-2 {{ $view === 'personal' ? 'active bg-primary' : '' }}" href="{{ route('wallets.expenses', ['wallet' => $wallet->id, 'view' => 'personal']) }}">
                            <i class="fas fa-user me-2"></i> Personal Only
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item rounded-3 py-2 {{ $view === 'customer' ? 'active bg-primary' : '' }}" href="{{ route('wallets.expenses', ['wallet' => $wallet->id, 'view' => 'customer']) }}">
                            <i class="fas fa-users me-2"></i> Customer Only
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Financial Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card diary-stat-card h-100 border-0 shadow-sm bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-success-subtle p-2 rounded-3 me-3">
                            <i class="fas fa-arrow-down text-success"></i>
                        </div>
                        <div class="text-uppercase small fw-bold text-muted">Total Received</div>
                    </div>
                    <h2 class="mb-0 text-success fw-bold">{{ number_format($totalReceived, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card diary-stat-card h-100 border-0 shadow-sm bg-white">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-danger-subtle p-2 rounded-3 me-3">
                            <i class="fas fa-arrow-up text-danger"></i>
                        </div>
                        <div class="text-uppercase small fw-bold text-muted">Total Spent</div>
                    </div>
                    <h2 class="mb-0 text-danger fw-bold">{{ number_format($totalSpent, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @php $net = $totalReceived - $totalSpent; @endphp
            <div class="card diary-stat-card h-100 border-0 shadow-sm {{ $net >= 0 ? 'bg-primary-subtle' : 'bg-danger-subtle' }}">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary p-2 rounded-3 me-3">
                            <!-- <i class="fas fa-exchange-alt text-white"></i> -->
                             <i class="fas {{ $net >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} text-white"></i>
                        </div>
                        <div class="text-uppercase small fw-bold text-muted">Net Flow</div>
                    </div>
                    <h2 class="mb-0 {{ $net >= 0 ? 'text-primary' : 'text-danger' }} fw-bold">{{ number_format($net, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    @if($groupedExpenses->count() > 0)
    <h5 class="mb-3 fw-bold text-muted"><i class="fas fa-history me-2"></i> Transaction History</h5>
    <div class="accordion" id="expenseHistoryAccordion">
        @foreach($groupedExpenses as $date => $group)
        <div class="accordion-item mb-2 border-0 shadow-sm rounded-4 overflow-hidden">
            <h2 class="accordion-header" id="heading-{{ $loop->index }}">
                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} bg-white py-3 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-{{ $loop->index }}">
                    <div class="d-flex justify-content-between w-100 align-items-center">
                        <div>
                            <i class="fas fa-calendar-day me-2 text-primary"></i>
                            Date: {{ $date }}
                        </div>
                        <span class="badge bg-light text-dark border me-3">{{ $group->count() }} records</span>
                    </div>
                </button>
            </h2>
            <div id="collapse-{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ $loop->index }}" data-bs-parent="#expenseHistoryAccordion">
                <div class="accordion-body p-0 border-top bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 small">Time</th>
                                    <th class="small">Type</th>
                                    <th class="small">Customer/Description</th>
                                    <th class="small">Received</th>
                                    <th class="small">Paid</th>
                                    <th class="small">Method</th>
                                    <th class="small">Description</th>
                                    <th class="text-end pe-3 small">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group as $expense)
                                <tr>
                                    <td class="ps-3 small text-muted">{{ $expense['created_at']->format('H:i') }}</td>
                                    <td>
                                        @if($expense['type'] === 'personal')
                                            <span class="badge bg-primary-subtle text-primary border-0 px-2 py-1" style="font-size: 0.65rem;">
                                                <i class="fas fa-user me-1"></i>PERSONAL
                                            </span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border-0 px-2 py-1" style="font-size: 0.65rem;">
                                                <i class="fas fa-users me-1"></i>CUSTOMER
                                            </span>
                                        @endif
                                    </td>
                                    <td class="fw-bold">
                                        @if($expense['type'] === 'customer')
                                            {{ $expense['customer_name'] ?? 'Unknown' }}
                                        @else
                                            Personal Expense
                                        @endif
                                    </td>
                                    <td class="text-success fw-bold">{{ $expense['credit'] > 0 ? number_format($expense['credit'], 2) : '-' }}</td>
                                    <td class="text-danger fw-bold">{{ $expense['debit'] > 0 ? number_format($expense['debit'], 2) : '-' }}</td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info border-0">{{ $expense['payment_method'] ?? 'Amount' }}</span>
                                    </td>
                                    <td class="small text-secondary">{{ $expense['description'] }}</td>
                                    <td class="text-end pe-3">
                                        @if($expense['type'] === 'personal')
                                            <form action="{{ route('wallets.entry.destroy', $expense['id']) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('run_balance.transactions.destroy', $expense['id']) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm border border-dashed">
            <i class="fas fa-receipt fa-4x mb-3 text-light"></i>
            <h4 class="text-muted fw-bold">No records found</h4>
            <p class="text-secondary opacity-75">There are no transactions recorded for this wallet view.</p>
        </div>
    @endif
</div>
@endsection
