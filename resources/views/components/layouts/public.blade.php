@props([
    'title' => 'Navara Boutique Hotel',
    'metaDescription' => 'Khách sạn phong cách hiện đại tại trung tâm thành phố với nhiều hạng phòng tiện nghi, đặt phòng nhanh chóng và tra cứu booking dễ dàng.',
])

@php
    $isHome = request()->routeIs('home');
    $isRooms = request()->routeIs('public.rooms.*');
    $isLookup = request()->routeIs('public.bookings.lookup') || request()->routeIs('public.bookings.lookup.submit');
    $isAbout = request()->routeIs('public.about');
    $isNews = request()->routeIs('public.news.*');
    $isContact = request()->routeIs('public.contact');

    $navLink = function (bool $active) {
        return $active
            ? 'text-[#173F8A]'
            : 'text-slate-600 hover:text-[#173F8A]';
    };

    $mobileNavLink = function (bool $active) {
        return $active
            ? 'bg-[#173F8A] text-white border-[#173F8A]'
            : 'bg-white text-slate-700 border-slate-200 hover:border-[#173F8A]/30 hover:text-[#173F8A]';
    };
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $metaDescription }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navara-navy: #173F8A;
            --navara-navy-dark: #143374;
            --navara-teal: #2EC4B6;
            --navara-teal-dark: #27B0A3;
        }

        .hotel-logo-lux {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            letter-spacing: 0.06em;
            line-height: 1;
        }

        .navara-gradient {
            background: linear-gradient(90deg, #173F8A 0%, #1E5AA8 42%, #2EC4B6 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .navara-gradient-light {
            background: linear-gradient(90deg, #ffffff 0%, #dce9ff 46%, #9ff4ec 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .header-glow {
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .nav-link-ui {
            position: relative;
        }

        .nav-link-ui::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -0.55rem;
            width: 100%;
            height: 2px;
            border-radius: 9999px;
            background: linear-gradient(90deg, rgba(23,63,138,0.95), rgba(46,196,182,0.9));
            transform: scaleX(0);
            transform-origin: center;
            transition: transform .25s ease;
        }

        .nav-link-ui.is-active::after,
        .nav-link-ui:hover::after {
            transform: scaleX(1);
        }

        .nav-btn-hover {
            transition: transform .25s ease, box-shadow .25s ease, background-color .25s ease, border-color .25s ease;
        }

        .nav-btn-hover:hover {
            transform: translateY(-1px);
        }

        .footer-link {
            transition: color .25s ease, transform .25s ease;
        }

        .footer-link:hover {
            color: #ffffff;
            transform: translateX(2px);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <div class="border-b border-white/10 bg-[#173F8A] text-slate-100">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-2.5 text-xs sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-3">
                <span>123 Đường Trung Tâm, Quận 1, TP.HCM</span>
                <span class="hidden sm:inline text-white/30">•</span>
                <a href="tel:0909000001" class="hover:text-white">0909 000 001</a>
                <span class="hidden sm:inline text-white/30">•</span>
                <a href="mailto:booking@hotel.test" class="hover:text-white">booking@hotel.test</a>
            </div>

            <div class="flex flex-wrap items-center gap-3 text-slate-200">
                <span>Check-in 14:00</span>
                <span class="hidden sm:inline text-white/30">•</span>
                <span>Check-out 12:00</span>
                <span class="hidden sm:inline text-white/30">•</span>
                <span>Hỗ trợ 24/7</span>
            </div>
        </div>
    </div>

    <header class="header-glow sticky top-0 z-50 border-b border-slate-200/90 bg-white/95 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-6">
                <a href="{{ route('home') }}" class="shrink-0">
                    <div class="leading-none">
                        <p class="hotel-logo-lux text-[2.35rem] sm:text-[2.65rem]">
                            <span class="navara-gradient">Navara</span>
                        </p>
                        <p class="mt-1 pl-0.5 text-[0.72rem] font-semibold uppercase tracking-[0.42em] text-slate-500 sm:text-xs">
                            Boutique Hotel
                        </p>
                    </div>
                </a>

                <nav class="hidden items-center gap-8 xl:flex">
                    <a href="{{ route('home') }}"
                       class="nav-link-ui {{ $isHome ? 'is-active' : '' }} text-sm font-semibold transition {{ $navLink($isHome) }}">
                        Trang chủ
                    </a>
                    <a href="{{ route('public.rooms.index') }}"
                       class="nav-link-ui {{ $isRooms ? 'is-active' : '' }} text-sm font-semibold transition {{ $navLink($isRooms) }}">
                        Phòng nghỉ
                    </a>
                    <a href="{{ route('public.about') }}"
                       class="nav-link-ui {{ $isAbout ? 'is-active' : '' }} text-sm font-semibold transition {{ $navLink($isAbout) }}">
                        Giới thiệu
                    </a>
                    <a href="{{ route('public.news.index') }}"
                       class="nav-link-ui {{ $isNews ? 'is-active' : '' }} text-sm font-semibold transition {{ $navLink($isNews) }}">
                        Cẩm nang
                    </a>
                    <a href="{{ route('public.contact') }}"
                       class="nav-link-ui {{ $isContact ? 'is-active' : '' }} text-sm font-semibold transition {{ $navLink($isContact) }}">
                        Liên hệ
                    </a>
                </nav>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('public.bookings.lookup') }}"
                        class="nav-btn-hover hidden rounded-full border border-[#173F8A]/20 px-4 py-2.5 text-sm font-semibold text-[#173F8A] hover:border-[#173F8A]/35 hover:bg-[#173F8A]/5 md:inline-flex"
                    >
                        Tra cứu booking
                    </a>

                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="nav-btn-hover inline-flex rounded-full bg-[#173F8A] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#143374] hover:shadow-[0_12px_28px_rgba(23,63,138,0.2)]"
                    >
                        Đặt phòng ngay
                    </a>
                </div>
            </div>

            <div class="mt-4 flex gap-2 overflow-x-auto pb-1 xl:hidden">
                <a href="{{ route('home') }}" class="nav-btn-hover whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition {{ $mobileNavLink($isHome) }}">Trang chủ</a>
                <a href="{{ route('public.rooms.index') }}" class="nav-btn-hover whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition {{ $mobileNavLink($isRooms) }}">Phòng nghỉ</a>
                <a href="{{ route('public.about') }}" class="nav-btn-hover whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition {{ $mobileNavLink($isAbout) }}">Giới thiệu</a>
                <a href="{{ route('public.news.index') }}" class="nav-btn-hover whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition {{ $mobileNavLink($isNews) }}">Cẩm nang</a>
                <a href="{{ route('public.contact') }}" class="nav-btn-hover whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition {{ $mobileNavLink($isContact) }}">Liên hệ</a>
                <a href="{{ route('public.bookings.lookup') }}" class="nav-btn-hover whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition {{ $mobileNavLink($isLookup) }}">Tra cứu</a>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-20 bg-[#173F8A] text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-[1.2fr_0.8fr_0.8fr_1fr] lg:px-8">
            <div>
                <div class="leading-none">
                    <p class="hotel-logo-lux text-[2.35rem]">
                        <span class="navara-gradient-light">Navara</span>
                    </p>
                    <p class="mt-1 pl-0.5 text-[0.72rem] font-semibold uppercase tracking-[0.42em] text-white/70">
                        Boutique Hotel
                    </p>
                </div>

                <p class="mt-5 max-w-md text-sm leading-7 text-slate-200">
                    Không gian lưu trú hiện đại, chỉn chu và thuận tiện cho cả khách công tác lẫn nghỉ dưỡng. Trải nghiệm đặt phòng rõ ràng, trực quan và đáng tin cậy.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="nav-btn-hover rounded-full bg-[#2EC4B6] px-4 py-2 text-sm font-semibold text-[#0f172a] hover:bg-[#27b0a3]"
                    >
                        Xem phòng
                    </a>
                    <a
                        href="{{ route('public.bookings.lookup') }}"
                        class="nav-btn-hover rounded-full border border-white/20 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10"
                    >
                        Tra cứu booking
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold uppercase tracking-[0.22em] text-white/70">Khám phá</h4>
                <div class="mt-5 space-y-3 text-sm">
                    <a href="{{ route('home') }}" class="footer-link block text-slate-200">Trang chủ</a>
                    <a href="{{ route('public.rooms.index') }}" class="footer-link block text-slate-200">Danh sách phòng</a>
                    <a href="{{ route('public.about') }}" class="footer-link block text-slate-200">Về chúng tôi</a>
                    <a href="{{ route('public.news.index') }}" class="footer-link block text-slate-200">Cẩm nang lưu trú</a>
                    <a href="{{ route('public.contact') }}" class="footer-link block text-slate-200">Liên hệ</a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold uppercase tracking-[0.22em] text-white/70">Thông tin lưu trú</h4>
                <div class="mt-5 space-y-3 text-sm text-slate-200">
                    <p>Nhận phòng: 14:00</p>
                    <p>Trả phòng: 12:00</p>
                    <p>Hỗ trợ khách hàng 24/7</p>
                    <p>Tra cứu booking bằng mã đặt phòng và thông tin liên hệ</p>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold uppercase tracking-[0.22em] text-white/70">Liên hệ</h4>
                <div class="mt-5 space-y-3 text-sm text-slate-200">
                    <p>123 Đường Trung Tâm, Quận 1, TP.HCM</p>
                    <p><a href="tel:0909000001" class="footer-link inline-block text-slate-200">0909 000 001</a></p>
                    <p><a href="mailto:booking@hotel.test" class="footer-link inline-block text-slate-200">booking@hotel.test</a></p>
                    <p>Luôn sẵn sàng hỗ trợ đặt phòng và giải đáp thông tin lưu trú.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-sm text-slate-300 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p>© {{ date('Y') }} Navara Boutique Hotel. All rights reserved.</p>
                <p>Không gian lưu trú tinh tế, hiện đại và đáng tin cậy cho mọi hành trình.</p>
            </div>
        </div>
    </footer>
</body>
</html>