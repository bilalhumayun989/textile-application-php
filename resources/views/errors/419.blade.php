<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Session Expired</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f4ff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .expire-card {
            background: white;
            border-radius: 24px;
            padding: 3rem 2.5rem;
            text-align: center;
            box-shadow: 0 8px 40px rgba(124,58,237,0.1);
            max-width: 420px;
            width: 100%;
        }
        .icon-wrap {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .countdown {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-top: 1rem;
        }
        .btn-go {
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(124,58,237,0.25);
            text-decoration: none;
            display: inline-block;
        }
        .btn-go:hover {
            background: linear-gradient(135deg, #6d28d9, #5b21b6);
            color: white;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="expire-card">
        <div class="icon-wrap">
            <svg width="32" height="32" fill="none" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="2"/>
                <path d="M12 7v5l3 3" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <h4 class="fw-bold mb-2" style="color:#1e293b;">Session Expired</h4>
        <p class="text-muted mb-4" style="font-size:0.9rem;">Your session timed out for security. Please log in again to continue.</p>
        <a href="{{ url('/login') }}" class="btn-go">Go to Login</a>
        <div class="countdown" id="countdown">Redirecting in <span id="sec">5</span>s...</div>
    </div>

    <script>
        let s = 5;
        const el = document.getElementById('sec');
        const timer = setInterval(() => {
            s--;
            el.textContent = s;
            if (s <= 0) {
                clearInterval(timer);
                window.location.href = '/login';
            }
        }, 1000);
    </script>
</body>
</html>
