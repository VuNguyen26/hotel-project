@props([
    'title' => 'Hotel Booking',
    'metaDescription' => 'Website đặt phòng khách sạn với danh sách phòng, tra cứu booking và trải nghiệm lưu trú hiện đại.',
])

@php
    $isHome = request()->routeIs('home');
    $isRooms = request()->routeIs('public.rooms.*');
    $isLookup = request()->routeIs('public.bookings.lookup') || request()->routeIs('public.bookings.lookup.submit');
    $isAbout = request()->routeIs('public.about');
    $isNews = request()->routeIs('public.news.*');
    $isContact = request()->routeIs('public.contact');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $metaDescription }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="border-b border-slate-200 bg-slate-950 text-slate-200">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-2 text-xs sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-3">
                <span>Hotline: 0909 000 001</span>
                <span class="hidden sm:inline">•</span>
                <span>Email: booking@hotel.test</span>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-slate-300">
                <span>Check-in: 14:00</span>
                <span class="hidden sm:inline">•</span>
                <span>Check-out: 12:00</span>
            </div>
        </div>
    </div>

    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-xl font-black tracking-tight text-slate-900">
                        Hotel Booking
                    </a>

                    <nav class="hidden items-center gap-2 xl:flex">
                        <a
                            href="{{ route('home') }}"
                            class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isHome ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-sky-600' }}"
                        >
                            Trang chủ
                        </a>

                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isRooms ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-sky-600' }}"
                        >
                            Phòng
                        </a>

                        <a
                            href="{{ route('public.about') }}"
                            class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isAbout ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-sky-600' }}"
                        >
                            Giới thiệu
                        </a>

                        <a
                            href="{{ route('public.news.index') }}"
                            class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isNews ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-sky-600' }}"
                        >
                            Tin tức
                        </a>

                        <a
                            href="{{ route('public.contact') }}"
                            class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isContact ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-sky-600' }}"
                        >
                            Liên hệ
                        </a>

                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isLookup ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100 hover:text-sky-600' }}"
                        >
                            Tra cứu booking
                        </a>
                    </nav>
                </div>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('public.bookings.lookup') }}"
                        class="hidden rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 md:inline-flex"
                    >
                        Tra cứu
                    </a>

                    <a
                        href="{{ route('login') }}"
                        class="rounded-xl bg-sky-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-sky-600"
                    >
                        Đăng nhập admin
                    </a>
                </div>
            </div>

            <div class="mt-4 flex gap-2 overflow-x-auto pb-1 xl:hidden">
                <a href="{{ route('home') }}" class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isHome ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700' }}">Trang chủ</a>
                <a href="{{ route('public.rooms.index') }}" class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isRooms ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700' }}">Phòng</a>
                <a href="{{ route('public.about') }}" class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isAbout ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700' }}">Giới thiệu</a>
                <a href="{{ route('public.news.index') }}" class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isNews ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700' }}">Tin tức</a>
                <a href="{{ route('public.contact') }}" class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isContact ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700' }}">Liên hệ</a>
                <a href="{{ route('public.bookings.lookup') }}" class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-semibold transition {{ $isLookup ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700' }}">Tra cứu booking</a>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-16 border-t border-slate-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-4 lg:px-8">
            <div>
                <h3 class="text-lg font-extrabold text-slate-900">Hotel Booking</h3>
                <p class="mt-4 text-sm leading-7 text-slate-600">
                    Nền tảng đặt phòng khách sạn với trải nghiệm trực quan, dễ tra cứu booking, phù hợp cho nghỉ dưỡng, công tác và gia đình.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Khám phá</h4>
                <div class="mt-4 space-y-3 text-sm">
                    <a href="{{ route('home') }}" class="block text-slate-600 hover:text-sky-600">Trang chủ</a>
                    <a href="{{ route('public.rooms.index') }}" class="block text-slate-600 hover:text-sky-600">Danh sách phòng</a>
                    <a href="{{ route('public.about') }}" class="block text-slate-600 hover:text-sky-600">Giới thiệu</a>
                    <a href="{{ route('public.news.index') }}" class="block text-slate-600 hover:text-sky-600">Tin tức</a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Hỗ trợ khách hàng</h4>
                <div class="mt-4 space-y-3 text-sm">
                    <a href="{{ route('public.bookings.lookup') }}" class="block text-slate-600 hover:text-sky-600">Tra cứu booking</a>
                    <a href="{{ route('public.contact') }}" class="block text-slate-600 hover:text-sky-600">Liên hệ</a>
                    <a href="{{ route('login') }}" class="block text-slate-600 hover:text-sky-600">Khu vực admin</a>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Liên hệ</h4>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <p>123 Đường Trung Tâm, Quận 1, TP.HCM</p>
                    <p>0909 000 001</p>
                    <p>booking@hotel.test</p>
                    <p>Hỗ trợ 24/7 cho khách đặt phòng</p>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p>© {{ date('Y') }} Hotel Booking. Demo user side.</p>
                <p>Laravel Hotel Admin + User UI</p>
            </div>
        </div>
    </footer>
</body>
</html>