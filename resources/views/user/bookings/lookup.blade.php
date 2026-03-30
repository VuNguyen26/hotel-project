@php
    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroBackground = $assetOrFallback(
        'images/user/booking-lookup-hero.jpg',
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80'
    );

    $lookupImage = $assetOrFallback(
        'images/user/booking-lookup-cover.jpg',
        'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1600&q=80'
    );

    $bookingCodeValue = old('booking_code');
    $phoneValue = old('phone');
    $emailValue = old('email');

    $hasErrors = $errors->any();

    $lookupTips = [
        'Nhập đúng mã booking đã nhận sau khi gửi yêu cầu đặt phòng.',
        'Dùng số điện thoại hoặc email đã khai báo trong form đặt phòng.',
        'Nếu nhập đúng nhưng chưa thấy kết quả, hãy kiểm tra lại ký tự BK-... hoặc thông tin liên hệ.',
    ];

    $lookupSteps = [
        [
            'title' => 'Nhập mã booking',
            'desc' => 'Sử dụng mã dạng BK-YYYYMMDD-XXXXXX được hệ thống cung cấp sau khi gửi booking.',
        ],
        [
            'title' => 'Xác thực bằng liên hệ',
            'desc' => 'Điền số điện thoại hoặc email đã dùng khi đặt phòng để đối chiếu chính xác.',
        ],
        [
            'title' => 'Xem lại trạng thái',
            'desc' => 'Hệ thống sẽ hiển thị tình trạng booking, lịch lưu trú và thông tin thanh toán liên quan.',
        ],
    ];

    $lookupStats = [
        ['label' => 'Tra cứu theo', 'value' => 'Mã booking + liên hệ'],
        ['label' => 'Kết quả hiển thị', 'value' => 'Trạng thái · Lưu trú · Thanh toán'],
        ['label' => 'Mục tiêu', 'value' => 'Nhanh · Rõ ràng · Chính xác'],
    ];
@endphp

<x-layouts.public
    title="Tra cứu booking | Navara Boutique Hotel"
    metaDescription="Tra cứu lại booking tại Navara Boutique Hotel bằng mã booking kèm số điện thoại hoặc email để xem trạng thái đặt phòng và thông tin thanh toán."
>
    <style>
        :root {
            --navara-navy: #173F8A;
            --navara-navy-deep: #081A45;
            --navara-teal: #2EC4B6;
            --navara-teal-dark: #27B0A3;
            --navara-border: rgba(15, 23, 42, 0.08);
            --navara-shadow-soft: 0 14px 40px rgba(15, 23, 42, 0.06);
            --navara-shadow-lg: 0 28px 70px rgba(8, 26, 69, 0.16);
        }

        @keyframes floatSoft {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes fadeUpSoft {
            0% {
                opacity: 0;
                transform: translateY(28px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeLeftSoft {
            0% {
                opacity: 0;
                transform: translateX(-28px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeRightSoft {
            0% {
                opacity: 0;
                transform: translateX(28px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .lookup-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .lookup-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .lookup-input {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.35);
            background: #fff;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            color: #0f172a;
            transition: .2s ease;
        }

        .lookup-input:focus {
            outline: none;
            border-color: rgba(23, 63, 138, 0.7);
            box-shadow: 0 0 0 4px rgba(23, 63, 138, 0.08);
        }

        .lookup-label {
            display: block;
            margin-bottom: .55rem;
            font-size: .92rem;
            font-weight: 700;
            color: #334155;
        }

        .lookup-chip {
            border: 1px solid rgba(23, 63, 138, 0.08);
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(6px);
        }

        .lookup-hero {
            position: relative;
            overflow: hidden;
            color: white;
            background-image:
                linear-gradient(
                    90deg,
                    rgba(8, 26, 69, 0.66) 0%,
                    rgba(8, 26, 69, 0.54) 34%,
                    rgba(13, 37, 92, 0.42) 68%,
                    rgba(13, 37, 92, 0.28) 100%
                ),
                url('{{ $heroBackground }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .lookup-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(46, 196, 182, 0.12), transparent 24%),
                linear-gradient(to top, rgba(8, 26, 69, 0.16), rgba(8, 26, 69, 0.02));
            pointer-events: none;
        }

        .lookup-hero-badge {
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
        }

        .lookup-hero-panel {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(9, 26, 64, 0.14);
            box-shadow: 0 28px 70px rgba(5, 15, 40, 0.18);
            backdrop-filter: blur(8px);
        }

        .lookup-hero-inner-card {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(8, 26, 69, 0.16);
        }

        .lookup-type-badge {
            background: rgba(255, 255, 255, 0.98);
            color: #0B245B;
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 14px 32px rgba(8, 26, 69, 0.22);
        }

        .hero-copy-reveal {
            opacity: 0;
            animation: fadeLeftSoft .85s cubic-bezier(.22, 1, .36, 1) .08s forwards;
        }

        .hero-panel-reveal {
            opacity: 0;
            animation: fadeRightSoft .9s cubic-bezier(.22, 1, .36, 1) .18s forwards;
        }

        .hero-stats-reveal {
            opacity: 0;
            animation: fadeUpSoft .7s cubic-bezier(.22, 1, .36, 1) forwards;
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(28px);
            will-change: transform, opacity;
        }

        .reveal-on-scroll.is-visible {
            animation: fadeUpSoft .8s cubic-bezier(.22, 1, .36, 1) forwards;
        }

        .reveal-delay-1 { animation-delay: .08s !important; }
        .reveal-delay-2 { animation-delay: .16s !important; }
        .reveal-delay-3 { animation-delay: .24s !important; }
        .reveal-delay-4 { animation-delay: .32s !important; }

        .nav-btn-hover {
            transition: transform .28s ease, box-shadow .28s ease, background-color .28s ease, border-color .28s ease, color .28s ease;
        }

        .nav-btn-hover:hover {
            transform: translateY(-2px);
        }

        @media (prefers-reduced-motion: reduce) {
            .lookup-floating-orb,
            .hero-copy-reveal,
            .hero-panel-reveal,
            .hero-stats-reveal,
            .reveal-on-scroll,
            .reveal-on-scroll.is-visible,
            .nav-btn-hover {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>

    <section class="lookup-hero min-h-[700px] lg:min-h-[760px]">
        <div class="lookup-floating-orb absolute -left-16 top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        <div class="lookup-floating-orb absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="hero-copy-reveal">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">Tra cứu booking</span>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <span class="lookup-hero-badge rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">
                            Kiểm tra trạng thái đặt phòng
                        </span>
                        <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold text-white/90">
                            Nhanh · Rõ ràng · Đúng thông tin
                        </span>
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[3.9rem] lg:leading-[1.04]">
                        Tra cứu lại booking đã gửi chỉ với mã booking và thông tin liên hệ.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        Dùng mã booking kèm số điện thoại hoặc email đã sử dụng lúc đặt phòng để xem lại tình trạng xác nhận, thời gian lưu trú và thông tin thanh toán liên quan.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="#booking-lookup-form"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Bắt đầu tra cứu
                        </a>

                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Khám phá phòng nghỉ
                        </a>
                    </div>
                </div>

                <div class="hero-panel-reveal lookup-hero-panel overflow-hidden rounded-[2rem] p-4 sm:p-5 lg:p-6">
                    <div class="lookup-hero-inner-card rounded-[1.75rem] p-6 text-slate-900 sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tra cứu thông minh</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                                    Xem lại booking mà không cần liên hệ thủ công
                                </h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Ví dụ mã</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">BK-20260330-000123</p>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3">
                            @foreach($lookupStats as $stat)
                                <div class="hero-stats-reveal rounded-[1.4rem] border border-slate-200 bg-white p-4" style="animation-delay: {{ 0.28 + ($loop->index * 0.08) }}s;">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $stat['label'] }}</p>
                                    <p class="mt-2 text-lg font-black text-slate-900">{{ $stat['value'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        @if($hasErrors)
                            <div class="mt-6 rounded-[1.5rem] border border-rose-200 bg-rose-50 p-4 text-rose-700">
                                <p class="text-sm font-semibold">
                                    Hệ thống chưa tìm được booking phù hợp hoặc thông tin nhập vào chưa đầy đủ.
                                </p>
                            </div>
                        @else
                            <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                                Sau khi tra cứu thành công, anh sẽ xem được chi tiết phòng, lịch lưu trú, trạng thái booking và phần thanh toán đã ghi nhận.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="booking-lookup-form" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-8">
                @if ($errors->any())
                    <div class="lookup-shell-card rounded-[2rem] border border-rose-200 bg-rose-50 p-6 text-rose-700">
                        <p class="text-base font-bold">Vui lòng kiểm tra lại thông tin tra cứu.</p>
                        <ul class="mt-3 list-disc space-y-1.5 pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="reveal-on-scroll reveal-delay-1 lookup-shell-card overflow-hidden rounded-[2rem] bg-white">
                    <div class="grid gap-0 lg:grid-cols-[0.92fr_1.08fr]">
                        <div class="relative min-h-[320px] overflow-hidden">
                            <img
                                src="{{ $lookupImage }}"
                                alt="Tra cứu booking"
                                class="h-full w-full object-cover"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#081A45]/80 via-[#081A45]/20 to-transparent"></div>

                            <div class="absolute inset-x-6 bottom-6 text-white">
                                <div class="flex flex-wrap gap-2">
                                    <span class="lookup-type-badge rounded-full px-3.5 py-1.5 text-xs font-extrabold tracking-[0.02em]">
                                        Booking Lookup
                                    </span>
                                    <span class="rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700 shadow-sm">
                                        Bảo mật theo liên hệ
                                    </span>
                                </div>

                                <h2 class="mt-5 text-3xl font-black tracking-tight">
                                    Xem lại booking nhanh mà vẫn đủ độ chính xác.
                                </h2>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Biểu mẫu tra cứu</p>
                            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                                Nhập mã booking và thông tin liên hệ đã dùng trước đó
                            </h2>

                            <p class="mt-4 text-sm leading-7 text-slate-600">
                                Hệ thống đối chiếu mã booking với email hoặc số điện thoại của khách hàng để đảm bảo kết quả trả về đúng booking cần xem.
                            </p>

                            <form method="POST" action="{{ route('public.bookings.lookup.submit') }}" class="mt-8 space-y-6" id="lookupForm">
                                @csrf

                                <div>
                                    <label class="lookup-label">
                                        Mã booking <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="booking_code"
                                        value="{{ $bookingCodeValue }}"
                                        class="lookup-input"
                                        placeholder="Ví dụ: BK-20260330-000123"
                                        autocomplete="off"
                                        id="bookingCodeInput"
                                    >
                                </div>

                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="lookup-label">Số điện thoại</label>
                                        <input
                                            type="text"
                                            name="phone"
                                            value="{{ $phoneValue }}"
                                            class="lookup-input"
                                            placeholder="Nhập số điện thoại đã dùng"
                                        >
                                    </div>

                                    <div>
                                        <label class="lookup-label">Email</label>
                                        <input
                                            type="email"
                                            name="email"
                                            value="{{ $emailValue }}"
                                            class="lookup-input"
                                            placeholder="Nhập email đã dùng"
                                        >
                                    </div>
                                </div>

                                <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                                    Anh chỉ cần nhập <strong>mã booking</strong> và ít nhất <strong>một thông tin liên hệ</strong> gồm số điện thoại hoặc email.
                                </div>

                                <div class="flex flex-wrap gap-4">
                                    <button
                                        type="submit"
                                        class="nav-btn-hover inline-flex rounded-full bg-[#173F8A] px-6 py-3 text-sm font-semibold text-white hover:bg-[#143374] hover:shadow-[0_14px_32px_rgba(23,63,138,0.18)]"
                                    >
                                        Tra cứu booking
                                    </button>

                                    <a
                                        href="{{ route('public.rooms.index') }}"
                                        class="nav-btn-hover inline-flex rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                                    >
                                        Xem phòng nghỉ
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 lookup-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Lưu ý khi tra cứu</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Một vài điểm giúp kết quả trả về nhanh và chính xác hơn.
                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-3">
                        @foreach($lookupTips as $tip)
                            <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                                <div class="text-[#173F8A]">✓</div>
                                <p class="mt-3 text-sm leading-7 text-slate-700">{{ $tip }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
                <div class="reveal-on-scroll reveal-delay-1 lookup-shell-card rounded-[2rem] bg-white p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tra cứu được gì?</p>
                    <h3 class="mt-3 text-2xl font-black text-slate-900">Thông tin sẽ hiển thị sau khi tìm thấy booking</h3>

                    <div class="mt-5 space-y-3">
                        <div class="lookup-chip rounded-[1.2rem] px-4 py-3 text-sm text-slate-700">
                            Mã booking và trạng thái hiện tại
                        </div>
                        <div class="lookup-chip rounded-[1.2rem] px-4 py-3 text-sm text-slate-700">
                            Khách hàng, phòng và lịch lưu trú
                        </div>
                        <div class="lookup-chip rounded-[1.2rem] px-4 py-3 text-sm text-slate-700">
                            Tổng tiền, đã thanh toán và còn lại
                        </div>
                        <div class="lookup-chip rounded-[1.2rem] px-4 py-3 text-sm text-slate-700">
                            Danh sách các lần thanh toán đã ghi nhận
                        </div>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 lookup-shell-card rounded-[2rem] bg-white p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Chưa có mã booking?</p>
                    <div class="mt-4 space-y-4 text-sm leading-7 text-slate-600">
                        <p>
                            Mã booking được hiển thị ngay sau khi anh gửi yêu cầu đặt phòng thành công.
                        </p>
                        <p>
                            Hãy lưu lại mã này hoặc chụp màn hình để tiện tra cứu trong những lần tiếp theo.
                        </p>
                    </div>

                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="nav-btn-hover mt-6 inline-flex w-full items-center justify-center rounded-full border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                    >
                        Đi tới danh sách phòng
                    </a>
                </div>

                <div class="reveal-on-scroll reveal-delay-3 lookup-shell-card rounded-[2rem] bg-[#081A45] p-6 text-white">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#9ff4ec]">Tiếp tục hành trình</p>
                    <h3 class="mt-3 text-2xl font-black">Muốn xem thêm lựa chọn trước khi đặt mới?</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Anh có thể quay lại khu vực phòng nghỉ để lọc theo ngày, loại phòng hoặc sức chứa rồi gửi booking mới khi cần.
                    </p>
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="nav-btn-hover mt-6 inline-flex rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#081A45] hover:bg-slate-100"
                    >
                        Khám phá phòng nghỉ
                    </a>
                </div>
            </aside>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const revealItems = document.querySelectorAll('.reveal-on-scroll');

            if (revealItems.length) {
                const revealNow = (el) => {
                    if (!el.classList.contains('is-visible')) {
                        el.classList.add('is-visible');
                    }
                };

                if (!('IntersectionObserver' in window)) {
                    revealItems.forEach(revealNow);
                } else {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                revealNow(entry.target);
                                observer.unobserve(entry.target);
                            }
                        });
                    }, {
                        threshold: 0.14,
                        rootMargin: '0px 0px -40px 0px'
                    });

                    revealItems.forEach((item) => observer.observe(item));
                }
            }

            const bookingCodeInput = document.getElementById('bookingCodeInput');
            if (!bookingCodeInput) return;

            bookingCodeInput.addEventListener('input', function () {
                const cursorStart = this.selectionStart;
                const cursorEnd = this.selectionEnd;
                this.value = this.value.toUpperCase();
                this.setSelectionRange(cursorStart, cursorEnd);
            });
        });
    </script>
</x-layouts.public>