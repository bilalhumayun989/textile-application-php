<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Textile Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f7f4ff;
            display: flex;
            align-items: stretch;
        }

        /* ── Left Panel ── */
        .login-left {
            width: 55%;
            background: linear-gradient(145deg, #7c3aed 0%, #4c1d95 60%, #2e1065 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -120px; left: -120px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            bottom: -80px; right: -80px;
        }

        .brand-logo {
            width: 72px; height: 72px;
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .left-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            text-align: center;
            line-height: 1.2;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .left-subtitle {
            color: rgba(255,255,255,0.65);
            text-align: center;
            font-size: 1rem;
            max-width: 340px;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .feature-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            justify-content: center;
            margin-top: 2.5rem;
            position: relative;
            z-index: 1;
        }

        .feature-pill {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 0.45rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            backdrop-filter: blur(6px);
        }

        /* ── Right Panel ── */
        .login-right {
            width: 45%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            background: #ffffff;
        }

        .login-form-wrap {
            width: 100%;
            max-width: 380px;
        }

        .form-eyebrow {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #7c3aed;
            margin-bottom: 0.5rem;
        }

        .form-title {
            font-size: 1.9rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 0.4rem;
        }

        .form-desc {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .field-group {
            margin-bottom: 1.25rem;
        }

        .field-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.45rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #c4b5fd;
            font-size: 0.9rem;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrap input {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.75rem;
            border: 2px solid #f1f0f7;
            border-radius: 12px;
            background: #faf9ff;
            font-size: 0.95rem;
            font-weight: 500;
            color: #1a1a2e;
            outline: none;
            transition: all 0.25s;
        }

        .input-wrap input:focus {
            border-color: #7c3aed;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(124,58,237,0.1);
        }

        .input-wrap input:focus ~ i {
            color: #7c3aed;
        }

        .input-wrap input::placeholder {
            color: #c4b5fd;
            font-weight: 400;
        }

        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124,58,237,0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.75rem 0;
            color: #e2e8f0;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f1f0f7;
        }

        .login-footer {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f0f7;
            text-align: center;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        .alert-custom {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success-custom {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .alert-danger-custom {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .login-left { width: 100%; padding: 2.5rem 1.5rem; min-height: 220px; }
            .left-title { font-size: 1.6rem; }
            .feature-pills { display: none; }
            .login-right { width: 100%; padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

    {{-- ── Left Branding Panel ── --}}
    <div class="login-left">
        <div class="brand-logo">
            <i class="fas fa-industry fa-2x text-white"></i>
        </div>
        <h1 class="left-title">Textile<br>Management</h1>
        <p class="left-subtitle">A complete platform for costing, wallets, ledgers, and financial analysis.</p>
        <div class="feature-pills">
            <span class="feature-pill"><i class="fas fa-wallet me-1"></i> Wallet Ledger</span>
            <span class="feature-pill"><i class="fas fa-calculator me-1"></i> Net Calculation</span>
            <span class="feature-pill"><i class="fas fa-university me-1"></i> Bank Tracking</span>
            <span class="feature-pill"><i class="fas fa-file-invoice me-1"></i> Costing</span>
        </div>
    </div>

    {{-- ── Right Form Panel ── --}}
    <div class="login-right">
        <div class="login-form-wrap">

            <p class="form-eyebrow">Secure Access</p>
            <h2 class="form-title">Welcome back</h2>
            <p class="form-desc">Sign in to continue to your dashboard.</p>

            @if(session('status'))
                <div class="alert-custom alert-success-custom">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-custom alert-danger-custom">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="field-group">
                    <label>Email Address</label>
                    <div class="input-wrap">
                        <input type="email" name="email" placeholder="you@example.com"
                            value="{{ old('email') }}" required autofocus>
                        <i class="fas fa-envelope"></i>
                    </div>
                    @error('email')
                        <div style="color:#dc2626; font-size:0.78rem; margin-top:0.35rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field-group">
                    <label>Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password" placeholder="••••••••" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    @error('password')
                        <div style="color:#dc2626; font-size:0.78rem; margin-top:0.35rem;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    Sign In <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="login-footer">
                Powered by <strong style="color:#7c3aed;">BroshTech Asset Management</strong>
            </div>

        </div>
    </div>

</body>
</html>
