<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Koperasiku') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('favicon-512.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; }

        body { margin: 0; padding: 0; }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* ===== LEFT PANEL ===== */
        .auth-left {
            display: none;
            flex: 1;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 50%, #8b5cf6 100%);
        }

        @media (min-width: 1024px) {
            .auth-left { display: flex; flex-direction: column; justify-content: center; align-items: center; }
        }

        /* Animated blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: blobFloat 8s ease-in-out infinite;
        }
        .blob-1 { width: 350px; height: 350px; background: #38bdf8; top: -80px; left: -80px; animation-delay: 0s; }
        .blob-2 { width: 280px; height: 280px; background: #818cf8; bottom: -60px; right: -40px; animation-delay: -3s; }
        .blob-3 { width: 200px; height: 200px; background: #a78bfa; top: 50%; left: 60%; animation-delay: -5s; }

        @keyframes blobFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33%       { transform: translate(20px, -30px) scale(1.05); }
            66%       { transform: translate(-15px, 20px) scale(0.95); }
        }

        .auth-left-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            padding: 2rem;
        }

        .auth-logo-circle {
            width: 90px; height: 90px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(12px);
            border: 2px solid rgba(255,255,255,0.35);
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }

        .auth-left-title {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .auth-left-sub {
            font-size: 1rem;
            opacity: 0.85;
            max-width: 300px;
            line-height: 1.6;
        }

        /* Feature pills */
        .feature-pills {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 2.5rem;
            width: 100%;
            max-width: 300px;
        }
        .feature-pill {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 50px;
            padding: 0.6rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
            text-align: left;
        }
        .feature-pill i { font-size: 1rem; width: 20px; text-align: center; }

        /* ===== RIGHT PANEL ===== */
        .auth-right {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #f8fafc;
            padding: 2rem 1.5rem;
        }

        @media (min-width: 1024px) {
            .auth-right { width: 480px; flex-shrink: 0; }
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
        }

        /* Mobile branding (only visible < lg) */
        .mobile-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .mobile-brand-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #0ea5e9, #6366f1);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 24px rgba(99,102,241,0.3);
        }
        @media (min-width: 1024px) { .mobile-brand { display: none; } }

        .auth-form-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.35rem;
        }
        .auth-form-sub {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 2rem;
        }

        /* Input styling */
        .field-group { margin-bottom: 1.25rem; }
        .field-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.4rem;
        }
        .field-wrap { position: relative; }
        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            pointer-events: none;
        }
        .field-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.9rem;
            color: #0f172a;
            background: white;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        .field-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1);
        }
        .field-input::placeholder { color: #cbd5e1; }

        .field-input-right {
            padding-right: 2.75rem !important;
        }
        .field-icon-right {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .field-icon-right:hover { color: #6366f1; }

        /* Submit button */
        .btn-auth {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #0ea5e9, #6366f1);
            color: white;
            font-weight: 700;
            font-size: 0.9375rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(99,102,241,0.35);
            margin-top: 0.5rem;
        }
        .btn-auth:hover { opacity: 0.92; box-shadow: 0 6px 24px rgba(99,102,241,0.45); }
        .btn-auth:active { transform: scale(0.98); }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1.25rem 0;
            color: #94a3b8;
            font-size: 0.8125rem;
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .auth-footer-link {
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
        }
        .auth-footer-link a {
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer-link a:hover { text-decoration: underline; }

        /* Error */
        .field-error { font-size: 0.78rem; color: #ef4444; margin-top: 0.3rem; display: block; }

        /* Checkbox row */
        .check-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
        .check-row label { display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; color: #475569; cursor: pointer; }
        .check-row input[type="checkbox"] { accent-color: #6366f1; width: 15px; height: 15px; border-radius: 4px; }
        .forgot-link { font-size: 0.8125rem; color: #6366f1; font-weight: 600; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="auth-wrapper">

        <!-- LEFT PANEL -->
        <div class="auth-left">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>

            <div class="auth-left-content">
                <div class="auth-logo-circle">
                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2L2 7l10 5 10-5-10-5z" fill="white" opacity="0.9"/>
                        <path d="M2 17l10 5 10-5M2 12l10 5 10-5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <div class="auth-left-title">KOPERASIKU</div>
                <div class="auth-left-sub">Sistem Manajemen Koperasi Sekolah yang modern, cepat, dan terpercaya.</div>

                <div class="feature-pills">
                    <div class="feature-pill">
                        <i class="fa-solid fa-wallet"></i>
                        Kelola saldo dengan mudah
                    </div>
                    <div class="feature-pill">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Belanja produk koperasi
                    </div>
                    <div class="feature-pill">
                        <i class="fa-solid fa-chart-line"></i>
                        Pantau riwayat transaksi
                    </div>
                    <div class="feature-pill">
                        <i class="fa-solid fa-shield-halved"></i>
                        Aman & terjamin
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="auth-right">
            <div class="auth-card">
                <!-- Mobile branding -->
                <div class="mobile-brand">
                    <div class="mobile-brand-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L2 7l10 5 10-5-10-5z" fill="white" opacity="0.9"/>
                            <path d="M2 17l10 5 10-5M2 12l10 5 10-5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                    </div>
                    <div style="font-size:1.25rem;font-weight:800;color:#0f172a;">KOPERASIKU</div>
                    <div style="font-size:0.8125rem;color:#64748b;">Sistem Manajemen Koperasi Sekolah</div>
                </div>

                {{ $slot }}
            </div>
        </div>

    </div>
</body>
</html>
