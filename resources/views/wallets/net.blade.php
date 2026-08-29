@extends('layouts.app')

@section('title','Net Calculation')

@section('content')
<style>
    .net-header, .diary-header {
        background: linear-gradient(135deg, #c9adf8ff 0%, #b588fdff 100%);
        padding: 2rem;
        border-radius: 24px;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(109, 40, 217, 0.15);
    }

    .asset-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 20px !important;
    }

    .asset-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(124, 58, 237, 0.1) !important;
    }

    .filter-card {
        border-radius: 20px !important;
        border: none !important;
    }

    .result-box {
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
    }

    .btn-save-net {
        background-color: white;
        color: #7c3aed;
        border: 2px solid #7c3aed;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .btn-save-net:hover {
        background-color: #7c3aed;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(124, 58, 237, 0.25);
    }

    .history-table th {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280 !important;
        font-weight: 700 !important;
        background-color: #f9fafb !important;
    }

    .breakdown-badge {
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.35em 0.75em;
        border-radius: 20px;
    }

    @media (max-width: 767px) {
        .asset-card .card-body { padding: 1.25rem !important; }
        .asset-card h3 { font-size: 1.4rem; }
    }
</style>

<div class="container mt-4" style="max-width:1100px;">

    {{-- ── Page Title (Diary-style Header) ── --}}
    <div class="diary-header d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 text-white">
        <div>
            <h2 class="mb-1 fw-bold">
                <i class="fas fa-calculator me-2"></i> Net Calculation
            </h2>
            <p class="mb-0 opacity-75">Visual analysis of your total assets and flows</p>
        </div>
        <div class="mt-3 mt-md-0">
            <span class="badge bg-white bg-opacity-25 rounded-pill px-4 py-2 fs-6 fw-bold">
                <i class="fas fa-calendar-alt me-2"></i> {{ now()->format('M d, Y') }}
            </span>
        </div>
    </div>

    {{-- ── Live Asset Summary Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            @php $cashCheckNegative = $liveTotalCashCheck < 0; @endphp
            <div class="card asset-card h-100 shadow-sm border-0" style="{{ $cashCheckNegative ? 'background:linear-gradient(135deg,#dc2626,#b91c1c) !important;' : '' }}">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 p-md-3 rounded-4 me-2 me-md-3 flex-shrink-0" style="background:{{ $cashCheckNegative ? 'rgba(255,255,255,0.2)' : 'rgba(124,58,237,0.1)' }};">
                            <i class="fas fa-money-bill-wave" style="color:{{ $cashCheckNegative ? 'white' : '#7c3aed' }};"></i>
                        </div>
                        <div class="text-uppercase small fw-bold {{ $cashCheckNegative ? 'text-white opacity-75' : 'text-muted' }}" style="font-size:0.7rem;">
                            {{ $cashCheckNegative ? 'Loan' : 'Cash / Check' }}
                        </div>
                    </div>
                    <h3 class="mb-0 fw-bold {{ $cashCheckNegative ? 'text-white' : 'text-dark' }}">{{ number_format($liveTotalCashCheck, 2) }}</h3>
                    <div class="{{ $cashCheckNegative ? 'text-white opacity-60' : 'text-muted' }} mt-1" style="font-size:0.72rem;">
                        Cash: {{ number_format($liveTotalCash, 2) }} &nbsp;|&nbsp; Cheque: {{ number_format($liveTotalCheck, 2) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card asset-card h-100 shadow-sm border-0">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info-subtle p-2 p-md-3 rounded-4 me-2 me-md-3 flex-shrink-0">
                            <i class="fas fa-university text-info"></i>
                        </div>
                        <div class="text-uppercase small fw-bold text-muted" style="font-size:0.7rem;">Bank</div>
                    </div>
                    <h3 class="mb-0 fw-bold text-dark">{{ number_format($liveTotalBank, 2) }}</h3>
                    <div class="text-muted mt-1" style="font-size:0.72rem;">Total bank balances</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            @php $liveNet = $liveTotalCashCheck + $liveTotalBank; @endphp
            <div class="card asset-card h-100 shadow-sm border-0" style="background: linear-gradient(135deg,#7c3aed,#6d28d9) !important;">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-white bg-opacity-25 p-2 p-md-3 rounded-4 me-2 me-md-3 flex-shrink-0">
                            <i class="fas fa-vault text-white"></i>
                        </div>
                        <div class="text-uppercase small fw-bold text-white opacity-75" style="font-size:0.7rem;">Net Assets</div>
                    </div>
                    <h3 class="mb-0 fw-bold text-white">{{ number_format($liveNet, 2) }}</h3>
                    <div class="text-white mt-1 opacity-60" style="font-size:0.72rem;">Cash/Check + Bank</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Filter & Analysis Card ── --}}
    <div class="card filter-card shadow-sm mb-4">
        <div class="card-body p-3 p-md-4">
            <h5 class="mb-4 fw-bold d-flex align-items-center">
                <i class="fas fa-filter me-2 text-primary"></i> Analysis Filters
            </h5>

            <form id="netCalcForm" method="GET" action="{{ route('wallets.net') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label small fw-bold text-muted">
                            <i class="fas fa-wallet me-1 text-primary opacity-75"></i> Wallet
                        </label>
                        <select name="wallet_id" class="form-select border-0 bg-light py-2 rounded-3" required>
                            @foreach($wallets as $w)
                                <option value="{{ $w->id }}" {{ $selectedWalletId == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-sm-3 col-md-3">
                        <label class="form-label small fw-bold text-muted">
                            <i class="fas fa-calendar-alt me-1 text-primary opacity-75"></i> From Date
                        </label>
                        <input type="date" name="date_from" class="form-control border-0 bg-light py-2 rounded-3" value="{{ $selectedDateFrom ?? now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-6 col-sm-3 col-md-3">
                        <label class="form-label small fw-bold text-muted">
                            <i class="fas fa-calendar-check me-1 text-primary opacity-75"></i> To Date
                        </label>
                        <input type="date" name="date_to" class="form-control border-0 bg-light py-2 rounded-3" value="{{ $selectedDateTo ?? now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <label class="form-label small fw-bold text-muted">
                            <i class="fas fa-eye me-1 text-primary opacity-75"></i> View Focus
                        </label>
                        <select name="customer_id" class="form-select border-0 bg-light py-2 rounded-3">
                            <option value="all" {{ $selectedCustomerId == 'all' ? 'selected' : '' }}>All Records</option>
                            <option value="personal" {{ $selectedCustomerId == 'personal' ? 'selected' : '' }}>Personal Only</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ $selectedCustomerId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-end gap-3">
                        <button type="submit" name="show_data" value="1" class="btn btn-primary px-4 fw-bold py-2 rounded-3 shadow-sm border-0" style="min-width: 140px;">
                            <i class="fas fa-search me-2"></i> Show Detailed Analysis
                        </button>
                        <button type="button" onclick="recordNet()" class="btn btn-save-net px-4 fw-bold py-2 rounded-3 border-2" style="min-width: 120px;">
                            <i class="fas fa-save me-2"></i> Save Record
                        </button>
                    </div>
                </div>
            </form>

            {{-- ── Results ── --}}
            @if($showResults)
            <div class="row mt-4 g-3">
                <div class="col-12 col-md-4">
                    <div class="result-box bg-light">
                        <div class="text-uppercase small fw-bold text-muted mb-2" style="font-size:0.7rem;">Total Received</div>
                        <h3 class="mb-0 fw-bold" style="color:#7c3aed;">{{ number_format($received, 2) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="result-box bg-light">
                        <div class="text-uppercase small fw-bold text-muted mb-2" style="font-size:0.7rem;">Total Used</div>
                        <h3 class="mb-0 fw-bold text-danger">{{ number_format($used, 2) }}</h3>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    @php $netNegative = ($net ?? 0) < 0; @endphp
                    <div class="result-box" style="{{ $netNegative ? 'background:linear-gradient(135deg,#dc2626,#b91c1c);' : 'background:linear-gradient(135deg,#7c3aed,#6d28d9);' }}">
                        <div class="text-uppercase small fw-bold mb-2 text-white opacity-75" style="font-size:0.7rem;">
                            {{ $netNegative ? 'Loan' : 'Net Balance' }}
                        </div>
                        <h3 class="mb-0 fw-bold text-white">{{ number_format(abs($net ?? 0), 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="accordion" id="breakdownAccordion">
                    <div class="accordion-item border-0 shadow-sm rounded-4 overflow-hidden">
                        <h2 class="accordion-header" id="breakdownHeading">
                            <button class="accordion-button collapsed bg-white py-3 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#breakdownCollapse" aria-expanded="false" aria-controls="breakdownCollapse">
                                <i class="fas fa-list-check me-2 text-primary"></i> Calculation Breakdown
                            </button>
                        </h2>
                        <div id="breakdownCollapse" class="accordion-collapse collapse" aria-labelledby="breakdownHeading" data-bs-parent="#breakdownAccordion">
                            <div class="accordion-body p-0 border-top bg-white">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr class="history-table">
                                                <th class="ps-3">Source</th>
                                                <th>Description</th>
                                                <th class="text-end pe-3">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($breakdown as $item)
                                            <tr>
                                                <td class="ps-3">
                                                    <span class="breakdown-badge
                                                        {{ $item['type'] == 'Ledger' ? 'bg-info-subtle text-info' : ($item['type'] == 'Bank' ? 'bg-warning-subtle text-warning' : 'bg-secondary-subtle text-secondary') }}">
                                                        <i class="fas {{ $item['type'] == 'Ledger' ? 'fa-users' : ($item['type'] == 'Bank' ? 'fa-university' : 'fa-user') }} me-1"></i>
                                                        {{ $item['type'] }}
                                                    </span>
                                                </td>
                                                <td class="text-dark small">{{ $item['desc'] }}</td>
                                                <td class="text-end pe-3 fw-bold {{ $item['kind'] == 'credit' ? '' : 'text-danger' }}" style="{{ $item['kind'] == 'credit' ? 'color:#7c3aed;' : '' }}">
                                                    {{ $item['kind'] == 'credit' ? '+' : '-' }}{{ number_format($item['amount'], 2) }}
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted small">No entries found for this range.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ── Calculation History ── --}}
    @if($groupedNetRecords->count() > 0)
    <h5 class="mb-3 fw-bold d-flex align-items-center">
        <i class="fas fa-history me-2 text-primary"></i> Calculation History
    </h5>
    <div class="accordion" id="netHistoryAccordion">
        @foreach($groupedNetRecords as $date => $group)
        <div class="accordion-item mb-2 border-0 shadow-sm rounded-4 overflow-hidden">
            <h2 class="accordion-header" id="heading-{{ $loop->index }}">
                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} bg-white py-3 fw-bold"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-{{ $loop->index }}"
                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                    aria-controls="collapse-{{ $loop->index }}">
                    <div class="d-flex justify-content-between w-100 align-items-center me-2">
                        <div>
                            <i class="fas fa-calendar-day me-2 text-primary opacity-75"></i>
                            {{ \Carbon\Carbon::parse($date)->format('D, M d Y') }}
                        </div>
                        <span class="badge bg-light text-muted border-0 rounded-pill px-3 fw-normal" style="font-size:0.72rem;">
                            {{ $group->count() }} record(s)
                        </span>
                    </div>
                </button>
            </h2>
            <div id="collapse-{{ $loop->index }}"
                class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                aria-labelledby="heading-{{ $loop->index }}"
                data-bs-parent="#netHistoryAccordion">
                <div class="accordion-body p-0 border-top bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="history-table">
                                <tr>
                                    <th class="ps-4">Time</th>
                                    <th>Focus</th>
                                    <th>Received</th>
                                    <th>Used</th>
                                    <th>Net</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group as $rec)
                                <tr>
                                    <td class="ps-4 text-muted small fw-bold">{{ $rec->created_at->format('H:i') }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border-0 rounded-pill px-3 py-1" style="font-size:0.7rem; font-weight:600;">
                                            {{ $rec->focus ?? 'General' }}
                                        </span>
                                    </td>
                                    <td class="fw-bold" style="color:#7c3aed;">{{ number_format($rec->received_total, 2) }}</td>
                                    <td class="fw-bold text-danger">{{ number_format($rec->used_total, 2) }}</td>
                                    <td>
                                        <span class="fw-bold {{ $rec->net_amount >= 0 ? '' : 'text-danger' }}" style="{{ $rec->net_amount >= 0 ? 'color:#7c3aed;' : '' }}">
                                            {{ number_format($rec->net_amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('wallets.net.destroy', $rec->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger border-0 p-2 rounded-3" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
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
    <div class="empty-state">
        <div class="mb-3" style="color:#e5e7eb;">
            <i class="fas fa-folder-open fa-4x"></i>
        </div>
        <h5 class="fw-bold text-dark">No History Yet</h5>
        <p class="text-muted small mb-0">Run an analysis and click Save to record it here.</p>
    </div>
    @endif

</div>

<script>
function recordNet() {
    const form = document.getElementById('netCalcForm');
    form.method = 'POST';
    form.action = "{{ route('wallets.net.store') }}";
    form.submit();
}
</script>
@endsection
