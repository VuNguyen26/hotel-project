@php
    $activeMode = old('auth_mode', $mode ?? (request()->routeIs('register') ? 'register' : 'login'));
@endphp

<x-guest-layout>
    <div class="navara-auth-page">
        <div class="navara-auth-card {{ $activeMode === 'register' ? 'is-register' : '' }}" id="navaraAuthCard">
            <a href="{{ route('home') }}" class="navara-home-btn navara-home-btn-mobile">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M10.75 19.25V14h2.5v5.25a.75.75 0 0 0 .75.75h3.5a.75.75 0 0 0 .75-.75V10.7a.75.75 0 0 0-.26-.57l-5.5-4.67a.75.75 0 0 0-.98 0l-5.5 4.67a.75.75 0 0 0-.26.57v8.55a.75.75 0 0 0 .75.75H10a.75.75 0 0 0 .75-.75Z" fill="currentColor"/>
                </svg>
                <span>Về trang chủ</span>
            </a>

            <div class="navara-form-wrap">
                {{-- LOGIN --}}
                <div class="navara-form-box navara-login-box">
                    <form method="POST" action="{{ route('login') }}" class="navara-form">
                        @csrf
                        <input type="hidden" name="auth_mode" value="login">

                        <h1>Đăng nhập</h1>

                        <div class="navara-socials">
                            <button type="button" class="navara-social" aria-label="Google">
                                <svg viewBox="0 0 48 48" aria-hidden="true">
                                    <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.6 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12S17.4 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.4-.4-3.5z"/>
                                    <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4c-7.7 0-14.3 4.3-17.7 10.7z"/>
                                    <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.5-5.3l-6.2-5.2C29.3 35.1 26.8 36 24 36c-5.2 0-9.6-3.3-11.3-8l-6.5 5C9.5 39.5 16.2 44 24 44z"/>
                                    <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.1-3.3 5.5-6.2 6.9l6.2 5.2C38.3 37.2 44 31.2 44 24c0-1.3-.1-2.4-.4-3.5z"/>
                                </svg>
                            </button>

                            <button type="button" class="navara-social" aria-label="Facebook">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill="#1877F2" d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073c0 6.019 4.388 11.009 10.125 11.927v-8.437H7.078v-3.49h3.047V9.413c0-3.021 1.792-4.689 4.533-4.689 1.313 0 2.686.236 2.686.236v2.965h-1.514c-1.491 0-1.956.931-1.956 1.887v2.261h3.328l-.532 3.49h-2.796V24C19.612 23.082 24 18.092 24 12.073z"/>
                                </svg>
                            </button>
                        </div>

                        <p class="navara-subtext">Đăng nhập để tiếp tục sử dụng hệ thống.</p>

                        @if ($errors->any() && $activeMode === 'login')
                            <div class="navara-alert navara-alert-error">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('status') && $activeMode === 'login')
                            <div class="navara-alert navara-alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <input
                            type="email"
                            name="email"
                            value="{{ old('auth_mode') === 'login' ? old('email') : '' }}"
                            placeholder="Email"
                            required
                            autofocus
                            autocomplete="username"
                        >

                        <input
                            type="password"
                            name="password"
                            placeholder="Mật khẩu"
                            required
                            autocomplete="current-password"
                        >

                        <label class="navara-check">
                            <input type="checkbox" name="remember">
                            <span>Ghi nhớ đăng nhập</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="navara-link">Quên mật khẩu?</a>
                        @endif

                        <button type="submit" class="navara-btn navara-btn-primary">
                            Đăng nhập
                        </button>

                        <button type="button" class="navara-mobile-switch" data-auth-switch="register">
                            Chưa có tài khoản? Đăng ký
                        </button>
                    </form>
                </div>

                {{-- REGISTER --}}
                <div class="navara-form-box navara-register-box">
                    <form method="POST" action="{{ route('register') }}" class="navara-form">
                        @csrf
                        <input type="hidden" name="auth_mode" value="register">

                        <h1>Đăng ký</h1>

                        <div class="navara-socials">
                            <button type="button" class="navara-social" aria-label="Google">
                                <svg viewBox="0 0 48 48" aria-hidden="true">
                                    <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.6 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12S17.4 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.4-.4-3.5z"/>
                                    <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4c-7.7 0-14.3 4.3-17.7 10.7z"/>
                                    <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.5-5.3l-6.2-5.2C29.3 35.1 26.8 36 24 36c-5.2 0-9.6-3.3-11.3-8l-6.5 5C9.5 39.5 16.2 44 24 44z"/>
                                    <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.1-3.3 5.5-6.2 6.9l6.2 5.2C38.3 37.2 44 31.2 44 24c0-1.3-.1-2.4-.4-3.5z"/>
                                </svg>
                            </button>

                            <button type="button" class="navara-social" aria-label="Facebook">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill="#1877F2" d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073c0 6.019 4.388 11.009 10.125 11.927v-8.437H7.078v-3.49h3.047V9.413c0-3.021 1.792-4.689 4.533-4.689 1.313 0 2.686.236 2.686.236v2.965h-1.514c-1.491 0-1.956.931-1.956 1.887v2.261h3.328l-.532 3.49h-2.796V24C19.612 23.082 24 18.092 24 12.073z"/>
                                </svg>
                            </button>
                        </div>

                        <p class="navara-subtext">Tạo tài khoản mới để sử dụng hệ thống.</p>

                        @if ($errors->any() && $activeMode === 'register')
                            <div class="navara-alert navara-alert-error">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <input
                            type="text"
                            name="name"
                            value="{{ old('auth_mode') === 'register' ? old('name') : '' }}"
                            placeholder="Họ và tên"
                            required
                            autocomplete="name"
                        >

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('auth_mode') === 'register' ? old('phone') : '' }}"
                            placeholder="Số điện thoại"
                            autocomplete="tel"
                        >

                        <input
                            type="email"
                            name="email"
                            value="{{ old('auth_mode') === 'register' ? old('email') : '' }}"
                            placeholder="Email"
                            required
                            autocomplete="username"
                        >

                        <input
                            type="password"
                            name="password"
                            placeholder="Mật khẩu"
                            required
                            autocomplete="new-password"
                        >

                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Xác nhận mật khẩu"
                            required
                            autocomplete="new-password"
                        >

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <label class="navara-check navara-check-terms">
                                <input type="checkbox" name="terms" id="terms" required>
                                <span>
                                    Tôi đồng ý với
                                    <a href="{{ route('terms.show') }}" target="_blank">điều khoản dịch vụ</a>
                                    và
                                    <a href="{{ route('policy.show') }}" target="_blank">chính sách bảo mật</a>
                                </span>
                            </label>
                        @endif

                        <button type="submit" class="navara-btn navara-btn-primary">
                            Đăng ký
                        </button>

                        <button type="button" class="navara-mobile-switch" data-auth-switch="login">
                            Đã có tài khoản? Đăng nhập
                        </button>
                    </form>
                </div>
            </div>

            {{-- OVERLAY --}}
            <div class="navara-overlay-wrap">
                <a href="{{ route('home') }}" class="navara-home-btn navara-home-btn-overlay">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M10.75 19.25V14h2.5v5.25a.75.75 0 0 0 .75.75h3.5a.75.75 0 0 0 .75-.75V10.7a.75.75 0 0 0-.26-.57l-5.5-4.67a.75.75 0 0 0-.98 0l-5.5 4.67a.75.75 0 0 0-.26.57v8.55a.75.75 0 0 0 .75.75H10a.75.75 0 0 0 .75-.75Z" fill="currentColor"/>
                    </svg>
                    <span>Về trang chủ</span>
                </a>

                <div class="navara-overlay">
                    <div class="navara-overlay-panel navara-overlay-left">
                        <h2>Chào mừng trở lại!</h2>
                        <p>Đăng nhập để tiếp tục quản lý thông tin và sử dụng đầy đủ tính năng.</p>
                        <button type="button" class="navara-btn navara-btn-ghost" data-auth-switch="login">
                            Đăng nhập
                        </button>
                    </div>

                    <div class="navara-overlay-panel navara-overlay-right">
                        <h2>Xin chào, bạn mới!</h2>
                        <p>Tạo tài khoản để bắt đầu trải nghiệm hệ thống với giao diện hiện đại và mượt hơn.</p>
                        <button type="button" class="navara-btn navara-btn-ghost" data-auth-switch="register">
                            Đăng ký
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --navara-navy: #173F8A;
            --navara-navy-dark: #143374;
            --navara-white: #ffffff;
            --navara-text: #0f172a;
            --navara-muted: #64748b;
            --navara-border: #d9e2ef;
            --navara-input: #f3f6fb;
            --navara-danger-bg: #fef2f2;
            --navara-danger-text: #b91c1c;
            --navara-success-bg: #ecfdf5;
            --navara-success-text: #047857;
        }

        .navara-auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            background:
                radial-gradient(circle at top left, rgba(46, 196, 182, 0.12), transparent 30%),
                radial-gradient(circle at bottom right, rgba(23, 63, 138, 0.16), transparent 36%),
                linear-gradient(135deg, #eef4ff 0%, #f8fbff 55%, #edf3ff 100%);
        }

        .navara-auth-card {
            position: relative;
            width: min(100%, 1120px);
            min-height: 700px;
            background: var(--navara-white);
            border-radius: 34px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(15, 23, 42, 0.16);
        }

        .navara-home-btn {
            position: absolute;
            top: 26px;
            right: 28px;
            left: auto;
            z-index: 50;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            height: 48px;
            padding: 0 18px;
            border-radius: 999px;
            text-decoration: none;
            font-size: .95rem;
            font-weight: 700;
            transition: all .25s ease;
        }

        .navara-auth-card.is-register .navara-home-btn-overlay {
            left: 28px;
            right: auto;
        }

        .navara-home-btn svg {
            width: 18px;
            height: 18px;
        }

        .navara-home-btn-overlay {
            background: rgba(255,255,255,0.95);
            border: 1px solid rgba(255,255,255,0.42);
            color: var(--navara-navy);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
        }

        .navara-home-btn-overlay:hover {
            transform: translateY(-1px);
            background: #fff;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.16);
        }

        .navara-home-btn-mobile {
            display: none;
            background: rgba(255,255,255,0.95);
            border: 1px solid rgba(23,63,138,0.14);
            color: var(--navara-navy);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        }

        .navara-home-btn-mobile:hover {
            transform: translateY(-1px);
            background: #fff;
            border-color: rgba(23,63,138,0.24);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.12);
        }

        .navara-form-wrap {
            position: absolute;
            inset: 0;
        }

        .navara-form-box {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px 46px;
            transition: transform .65s ease, opacity .45s ease, visibility .45s ease;
        }

        .navara-login-box {
            z-index: 3;
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .navara-register-box {
            z-index: 1;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .navara-auth-card.is-register .navara-login-box {
            transform: translateX(100%);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            z-index: 1;
        }

        .navara-auth-card.is-register .navara-register-box {
            transform: translateX(100%);
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            z-index: 5;
        }

        .navara-form {
            width: 100%;
            max-width: 380px;
            text-align: center;
        }

        .navara-form h1 {
            margin: 0 0 18px;
            color: var(--navara-text);
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .navara-socials {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .navara-social {
            width: 46px;
            height: 46px;
            border-radius: 999px;
            border: 1px solid var(--navara-border);
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
            cursor: pointer;
        }

        .navara-social svg {
            width: 22px;
            height: 22px;
        }

        .navara-social:hover {
            transform: translateY(-2px);
            border-color: rgba(23, 63, 138, 0.22);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
        }

        .navara-subtext {
            margin: 0 0 18px;
            font-size: 1rem;
            line-height: 1.7;
            color: var(--navara-muted);
        }

        .navara-form input[type="text"],
        .navara-form input[type="email"],
        .navara-form input[type="password"] {
            width: 100%;
            height: 58px;
            border: 1px solid transparent;
            border-radius: 16px;
            background: var(--navara-input);
            padding: 0 18px;
            margin-top: 14px;
            font-size: 1rem;
            color: var(--navara-text);
            outline: none;
            transition: all .25s ease;
        }

        .navara-form input[type="text"]:focus,
        .navara-form input[type="email"]:focus,
        .navara-form input[type="password"]:focus {
            border-color: rgba(23, 63, 138, 0.26);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(23, 63, 138, 0.08);
        }

        .navara-check {
            margin-top: 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            text-align: left;
            font-size: .94rem;
            line-height: 1.6;
            color: var(--navara-muted);
        }

        .navara-check input {
            margin-top: 4px;
            accent-color: var(--navara-navy);
        }

        .navara-check-terms a,
        .navara-link {
            color: var(--navara-navy);
            font-weight: 700;
            text-decoration: none;
        }

        .navara-link {
            display: inline-block;
            margin-top: 14px;
        }

        .navara-btn {
            border: none;
            cursor: pointer;
            font-weight: 800;
            transition: all .25s ease;
        }

        .navara-btn-primary {
            width: 100%;
            margin-top: 20px;
            height: 60px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--navara-navy) 0%, #244fb0 100%);
            color: #fff;
            font-size: 1rem;
            box-shadow: 0 20px 35px rgba(23, 63, 138, 0.16);
        }

        .navara-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 42px rgba(23, 63, 138, 0.22);
        }

        .navara-btn-ghost {
            margin-top: 20px;
            min-width: 180px;
            height: 52px;
            padding: 0 28px;
            border-radius: 999px;
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.48);
            font-size: 1rem;
        }

        .navara-btn-ghost:hover {
            background: rgba(255,255,255,.12);
            transform: translateY(-1px);
        }

        .navara-mobile-switch {
            display: none;
            margin: 16px auto 0;
            background: transparent;
            color: var(--navara-navy);
            font-weight: 800;
            border: none;
            cursor: pointer;
        }

        .navara-alert {
            margin-bottom: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            text-align: left;
            font-size: .92rem;
        }

        .navara-alert ul {
            margin: 0;
            padding-left: 18px;
        }

        .navara-alert-error {
            background: var(--navara-danger-bg);
            color: var(--navara-danger-text);
        }

        .navara-alert-success {
            background: var(--navara-success-bg);
            color: var(--navara-success-text);
        }

        .navara-overlay-wrap {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            z-index: 20;
            transition: transform .65s ease-in-out;
            border-radius: 180px 0 0 180px;
        }

        .navara-auth-card.is-register .navara-overlay-wrap {
            transform: translateX(-100%);
            border-radius: 0 180px 180px 0;
        }

        .navara-overlay {
            position: relative;
            left: -100%;
            width: 200%;
            height: 100%;
            background:
                radial-gradient(circle at top left, rgba(255,255,255,.16), transparent 30%),
                linear-gradient(135deg, #335dc1 0%, #21479f 38%, #173F8A 68%, #123370 100%);
            color: #fff;
            transform: translateX(0);
            transition: transform .65s ease-in-out;
        }

        .navara-auth-card.is-register .navara-overlay {
            transform: translateX(50%);
        }

        .navara-overlay-panel {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
            text-align: center;
        }

        .navara-overlay-panel h2 {
            margin: 0;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.15;
        }

        .navara-overlay-panel p {
            margin-top: 18px;
            max-width: 360px;
            font-size: 1.2rem;
            line-height: 1.8;
            color: rgba(255,255,255,.92);
        }

        .navara-overlay-left {
            transform: translateX(-20%);
        }

        .navara-auth-card.is-register .navara-overlay-left {
            transform: translateX(0);
        }

        .navara-overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .navara-auth-card.is-register .navara-overlay-right {
            transform: translateX(20%);
        }

        @media (max-width: 980px) {
            .navara-auth-card {
                min-height: auto;
            }

            .navara-home-btn-mobile {
                display: inline-flex;
                top: 16px;
                right: 16px;
                height: 42px;
                padding: 0 14px;
                font-size: .88rem;
            }

            .navara-home-btn-mobile span {
                display: none;
            }

            .navara-home-btn-mobile svg {
                width: 17px;
                height: 17px;
            }

            .navara-overlay-wrap {
                display: none;
            }

            .navara-form-wrap {
                position: relative;
            }

            .navara-form-box {
                position: relative;
                width: 100%;
                height: auto;
                padding: 34px 22px;
                transform: none !important;
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
                display: none;
            }

            .navara-login-box {
                display: flex;
            }

            .navara-register-box {
                display: none;
            }

            .navara-auth-card.is-register .navara-login-box {
                display: none;
            }

            .navara-auth-card.is-register .navara-register-box {
                display: flex;
            }

            .navara-form {
                max-width: 100%;
            }

            .navara-form h1 {
                font-size: 2.2rem;
            }

            .navara-mobile-switch {
                display: inline-block;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const card = document.getElementById('navaraAuthCard');
            if (!card) return;

            const loginUrl = @json(route('login'));
            const registerUrl = @json(route('register'));

            document.querySelectorAll('[data-auth-switch]').forEach((button) => {
                button.addEventListener('click', function () {
                    const mode = this.getAttribute('data-auth-switch');
                    card.classList.toggle('is-register', mode === 'register');

                    if (window.history && window.history.replaceState) {
                        window.history.replaceState({}, '', mode === 'register' ? registerUrl : loginUrl);
                    }
                });
            });
        });
    </script>
</x-guest-layout>