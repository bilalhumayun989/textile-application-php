@extends('layouts.app')

@section('title', 'Banks Portfolio - ' . $wallet->name)

@section('content')
<style>
    :root {
        --accent: #7C3AED;
        --accent-dark: #6D28D9;
        --accent-light: rgba(124,58,237,0.08);
        --card-radius: 20px;
        --card-shadow: 0 4px 24px rgba(124,58,237,0.07);
        --card-shadow-hover: 0 12px 36px rgba(124,58,237,0.13);
    }

    .banks-header {
        background: linear-gradient(135deg, #c9adf8 0%, #b588fd 100%);
        padding: 2rem 2.5rem;
        border-radius: 24px;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(109,40,217,0.18);
    }

    .stat-card {
        background: white;
        border-radius: var(--card-radius);
        border: none;
        box-shadow: var(--card-shadow);
        padding: 1.25rem 1.5rem;
        transition: box-shadow 0.25s ease;
    }

    .stat-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .stat-label {
        font-size: 0.62rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #94A3B8;
        margin-bottom: 0.4rem;
    }

    .bank-row {
        background: white;
        border-radius: var(--card-radius);
        border: none;
        box-shadow: var(--card-shadow);
        padding: 1.25rem 1.75rem;
        transition: box-shadow 0.25s ease, transform 0.25s ease;
    }

    .bank-row:hover {
        box-shadow: var(--card-shadow-hover);
        transform: translateY(-2px);
    }

    .bank-icon {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 14px;
        background: var(--accent-light);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .balance-pill {
        background: #F8F5FF;
        border: 1.5px solid rgba(124,58,237,0.12);
        border-radius: 14px;
        padding: 0.55rem 1.25rem;
        min-width: 130px;
        text-align: center;
    }

    .balance-pill.negative {
        background: #FFF5F5;
        border-color: rgba(220,38,38,0.2);
    }

    .field-wrap {
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 0 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        height: 44px;
    }

    .field-wrap:focus-within {
        border-color: var(--accent);
        background: white;
        box-shadow: 0 0 0 3px rgba(124,58,237,0.1);
    }

    .field-wrap input {
        background: transparent;
        border: none;
        outline: none;
        font-weight: 600;
        font-size: 0.9rem;
        color: #1E293B;
        width: 100%;
        height: 100%;
    }

    .field-wrap input::placeholder {
        color: #CBD5E1;
        font-weight: 500;
    }

    .btn-update {
        background: var(--accent);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0 1.4rem;
        height: 44px;
        font-weight: 700;
        font-size: 0.85rem;
        white-space: nowrap;
        transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 12px rgba(124,58,237,0.22);
    }

    .btn-update:hover {
        background: var(--accent-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(124,58,237,0.3);
        color: white;
    }

    .divider-line {
        border: none;
        border-top: 1.5px solid #F1F5F9;
        margin: 0.1rem 0 1rem;
    }

    .empty-banks {
        background: white;
        border-radius: var(--card-radius);
        box-shadow: var(--card-shadow);
        padding: 3.5rem 2rem;
        text-align: center;
    }
</style>

<div class="container mt-4" style="max-width: 960px;">

    {{-- Header --}}
    <div class="banks-header d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div>
            <h2 class="mb-1 fw-bold fs-4">
                <i class="fas fa-university me-2"></i> Banks Portfolio
            </h2>
            <p class="mb-0 opacity-75" style="font-size:0.85rem;">Manage your institutional balances</p>
        </div>
        <div class="text-md-end">
            <div class="opacity-75" style="font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Consolidated Balance</div>
            <div class="fw-bold fs-3">{{ number_format($banks->sum('balance'), 2) }}</div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-label">Active Accounts</div>
                <div class="h4 mb-0 fw-bold text-dark">{{ $banks->count() }}</div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="stat-card">
                <div class="stat-label">Account Owner</div>
                <div class="h5 mb-0 fw-bold text-dark">
                    <i class="fas fa-user-circle me-2" style="color:var(--accent); opacity:0.6;"></i>{{ $wallet->name }}
                </div>
            </div>
        </div>
    </div>

    {{-- Bank Rows --}}
    <div class="d-flex flex-column gap-3">
        @foreach($banks as $bank)
        <div class="bank-row">
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-3">

                {{-- Icon + Name --}}
                <div class="d-flex align-items-center gap-3 flex-grow-1">
                    <div class="bank-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size:0.95rem;">{{ $bank->name }}</div>
                        <div class="text-muted" style="font-size:0.72rem;">
                            <i class="fas fa-circle me-1" style="font-size:0.45rem; color:#22c55e;"></i>Active
                        </div>
                    </div>
                </div>

                {{-- Balance --}}
                <div class="balance-pill {{ $bank->balance < 0 ? 'negative' : '' }}">
                    <div class="stat-label mb-1">Live Balance</div>
                    <div class="fw-bold fs-6 {{ $bank->balance < 0 ? 'text-danger' : '' }}" style="{{ $bank->balance >= 0 ? 'color:var(--accent);' : '' }}">
                        {{ number_format($bank->balance, 2) }}
                    </div>
                </div>

                {{-- Update Form --}}
                <form action="{{ route('banks.update', $bank->id) }}" method="POST" class="d-flex gap-2 align-items-center" style="min-width:280px;">
                    @csrf
                    @method('PUT')
                    <div class="field-wrap flex-grow-1">
                        <i class="fas fa-coins" style="color:#CBD5E1; font-size:0.8rem;"></i>
                        <input type="number" name="amount" placeholder="New balance" step="0.01" min="0" required>
                    </div>
                    <button type="submit" class="btn-update">
                        <i class="fas fa-check me-1"></i> Update
                    </button>
                </form>

            </div>
        </div>
        @endforeach
    </div>

    @if($banks->count() === 0)
    <div class="empty-banks mt-2">
        <div class="mb-3" style="color:#E2E8F0;">
            <i class="fas fa-piggy-bank fa-3x"></i>
        </div>
        <h5 class="fw-bold text-dark mb-1">No Bank Accounts</h5>
        <p class="text-muted small mb-0">Link institutional accounts from your wallet settings.</p>
    </div>
    @endif

</div>
@endsection
