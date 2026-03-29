<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Hotel Booking' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-xl font-extrabold tracking-tight text-slate-900">
                    Hotel Booking
                </a>

                <nav class="hidden items-center gap-6 md:flex">
                    <a href="{{ route('home') }}"
                    class="text-sm font-semibold text-slate-700 transition hover:text-sky-600">
                        Trang chủ
                    </a>

                    <a href="{{ route('public.rooms.index') }}"
                    class="text-sm font-semibold text-slate-700 transition hover:text-sky-600">
                        Phòng
                    </a>

                    <a href="{{ route('public.bookings.lookup') }}"
                    class="text-sm font-semibold text-slate-700 transition hover:text-sky-600">
                        Tra cứu booking
                    </a>
                </nav>
            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('login') }}"
                    class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100"
                >
                    Đăng nhập admin
                </a>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-16 border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-2 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p>© {{ date('Y') }} Hotel Booking. Demo user side.</p>
                <p>Laravel Hotel Admin + User UI</p>
            </div>
        </div>
    </footer>
</body>
</html>