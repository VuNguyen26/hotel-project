@php
    use Carbon\Carbon;

    $today = now()->toDateString();

    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroBackground = $assetOrFallback(
        'images/user/booking-hero.jpg',
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80'
    );

    $displayCheckIn = old('check_in_date', $checkInDate);
    $displayCheckOut = old('check_out_date', $checkOutDate);

    $previewNights = null;
    $previewTotal = null;
    $formattedCheckIn = null;
    $formattedCheckOut = null;

    if ($displayCheckIn && $displayCheckOut) {
        try {
            $previewCheckIn = Carbon::parse($displayCheckIn);
            $previewCheckOut = Carbon::parse($displayCheckOut);

            if ($previewCheckOut->gt($previewCheckIn)) {
                $previewNights = max($previewCheckIn->diffInDays($previewCheckOut), 1);
                $previewTotal = $previewNights * ($room->roomType?->price ?? 0);
                $formattedCheckIn = $previewCheckIn->format('d/m/Y');
                $formattedCheckOut = $previewCheckOut->format('d/m/Y');
            }
        } catch (\Throwable $e) {
            $previewNights = null;
            $previewTotal = null;
            $formattedCheckIn = null;
            $formattedCheckOut = null;
        }
    }

    $price = (int) ($room->roomType?->price ?? 0);
    $capacity = (int) ($room->roomType?->capacity ?? 0);

    $roomImage = $assetOrFallback(
        'images/user/booking-room-cover.jpg',
        'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1600&q=80'
    );

    $badgeClasses = match($room->status) {
        'available' => 'bg-emerald-100 text-emerald-700',
        'booked' => 'bg-amber-100 text-amber-700',
        'occupied' => 'bg-rose-100 text-rose-700',
        default => 'bg-slate-100 text-slate-700',
    };

    $statusText = match($room->status) {
        'available' => 'Còn trống',
        'booked' => 'Đã được đặt',
        'occupied' => 'Đang sử dụng',
        default => ucfirst((string) $room->status),
    };

    $area = match(true) {
        $capacity >= 4 => '42 - 55 m²',
        $capacity === 3 => '32 - 40 m²',
        $capacity === 2 => '26 - 34 m²',
        default => '22 - 28 m²',
    };

    $typeName = strtolower($room->roomType?->name ?? '');

    $bedInfo = match(true) {
        str_contains($typeName, 'family') => '2 giường lớn',
        str_contains($typeName, 'suite') => '1 giường king + sofa',
        str_contains($typeName, 'double') => '1 giường đôi lớn',
        str_contains($typeName, 'single') => '1 giường đơn',
        default => '1 giường đôi',
    };

    $benefits = [
        'Giữ nguyên liên kết với phòng đã chọn, tránh đặt nhầm hạng phòng.',
        'Tự tính số đêm và chi phí tạm tính theo ngày lưu trú.',
        'Thông tin sau khi gửi sẽ được admin tiếp nhận và xác nhận lại.',
    ];

    $contactHint = 'Vui lòng nhập ít nhất số điện thoại hoặc email để hệ thống hỗ trợ tra cứu booking sau này.';

    $heroStats = [
        ['label' => 'Giá tham khảo', 'value' => number_format($price, 0, ',', '.') . ' đ / đêm'],
        ['label' => 'Sức chứa', 'value' => $capacity . ' người'],
        ['label' => 'Diện tích', 'value' => $area],
    ];
@endphp

<x-layouts.public
    title="Đặt phòng {{ $room->room_number }} | Navara Boutique Hotel"
    metaDescription="Gửi yêu cầu đặt phòng {{ $room->room_number }} tại Navara Boutique Hotel, chọn ngày lưu trú, nhập thông tin khách hàng và xem chi phí tạm tính rõ ràng."
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

        .booking-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .booking-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .booking-input {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.35);
            background: #fff;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            color: #0f172a;
            transition: .2s ease;
        }

        .booking-input:focus {
            outline: none;
            border-color: rgba(23, 63, 138, 0.7);
            box-shadow: 0 0 0 4px rgba(23, 63, 138, 0.08);
        }

        .booking-label {
            display: block;
            margin-bottom: .55rem;
            font-size: .92rem;
            font-weight: 700;
            color: #334155;
        }

        .booking-note-chip {
            border: 1px solid rgba(23, 63, 138, 0.08);
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(6px);
        }

        .booking-hero {
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

        .booking-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(46, 196, 182, 0.12), transparent 24%),
                linear-gradient(to top, rgba(8, 26, 69, 0.16), rgba(8, 26, 69, 0.02));
            pointer-events: none;
        }

        .booking-hero-badge {
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
        }

        .booking-hero-panel {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(9, 26, 64, 0.14);
            box-shadow: 0 28px 70px rgba(5, 15, 40, 0.18);
            backdrop-filter: blur(8px);
        }

        .booking-hero-inner-card {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(8, 26, 69, 0.16);
        }

        .booking-type-badge {
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
            .booking-floating-orb,
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

    <section class="booking-hero min-h-[700px] lg:min-h-[760px]">
        <div class="booking-floating-orb absolute -left-16 top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        <div class="booking-floating-orb absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="hero-copy-reveal">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <a
                            href="{{ route('public.rooms.index', array_filter([
                                'check_in_date' => $displayCheckIn,
                                'check_out_date' => $displayCheckOut,
                            ])) }}"
                            class="transition hover:text-white"
                        >
                            Phòng nghỉ
                        </a>
                        <span class="text-white/35">/</span>
                        <a
                            href="{{ route('public.rooms.show', array_filter([
                                'room' => $room->id,
                                'check_in_date' => $displayCheckIn,
                                'check_out_date' => $displayCheckOut,
                            ])) }}"
                            class="transition hover:text-white"
                        >
                            Phòng {{ $room->room_number }}
                        </a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">Đặt phòng</span>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <span class="booking-hero-badge rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">
                            Gửi yêu cầu đặt phòng
                        </span>
                        <span class="rounded-full px-4 py-2 text-xs font-bold {{ $badgeClasses }}">
                            {{ $statusText }}
                        </span>
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[3.9rem] lg:leading-[1.04]">
                        Hoàn tất thông tin để gửi yêu cầu đặt phòng {{ $room->room_number }}.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        Form đặt phòng được thiết kế để thao tác nhanh, rõ ràng và bám sát đúng phòng anh đã chọn. Hệ thống sẽ tự tính số đêm và chi phí tạm tính theo ngày lưu trú.
                    </p>

                    @if($formattedCheckIn && $formattedCheckOut)
                        <div class="mt-6 inline-flex rounded-full border border-emerald-300/20 bg-emerald-400/10 px-4 py-2 text-sm font-semibold text-emerald-100">
                            Lịch đang chọn: {{ $formattedCheckIn }} → {{ $formattedCheckOut }}
                        </div>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="{{ route('public.rooms.show', array_filter([
                                'room' => $room->id,
                                'check_in_date' => $displayCheckIn,
                                'check_out_date' => $displayCheckOut,
                            ])) }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Quay lại chi tiết phòng
                        </a>

                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Tra cứu booking
                        </a>
                    </div>
                </div>

                <div class="hero-panel-reveal booking-hero-panel overflow-hidden rounded-[2rem] p-4 sm:p-5 lg:p-6">
                    <div class="booking-hero-inner-card rounded-[1.75rem] p-6 text-slate-900 sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Phòng đang chọn</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                                    {{ $room->roomType?->name ?? 'Hạng phòng' }} · {{ $room->room_number }}
                                </h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Giá tham khảo</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">{{ number_format($price, 0, ',', '.') }} đ / đêm</p>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3 sm:grid-cols-3">
                            @foreach($heroStats as $stat)
                                <div class="hero-stats-reveal rounded-[1.4rem] border border-slate-200 bg-white p-4" style="animation-delay: {{ 0.28 + ($loop->index * 0.08) }}s;">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $stat['label'] }}</p>
                                    <p class="mt-2 text-lg font-black text-slate-900">{{ $stat['value'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                            {{ $room->roomType?->description ?: 'Không gian lưu trú được bố trí theo hướng chỉn chu, hiện đại và phù hợp cho cả khách công tác lẫn nghỉ dưỡng ngắn ngày.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-8">
                @if ($errors->any())
                    <div class="booking-shell-card rounded-[2rem] border border-rose-200 bg-rose-50 p-6 text-rose-700">
                        <p class="text-base font-bold">Vui lòng kiểm tra lại thông tin đã nhập.</p>
                        <ul class="mt-3 list-disc space-y-1.5 pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="reveal-on-scroll reveal-delay-1 booking-shell-card overflow-hidden rounded-[2rem] bg-white">
                    <div class="grid gap-0 lg:grid-cols-[0.92fr_1.08fr]">
                        <div class="relative min-h-[320px] overflow-hidden">
                            <img
                                src="{{ $roomImage }}"
                                alt="Phòng {{ $room->room_number }}"
                                class="h-full w-full object-cover"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#081A45]/80 via-[#081A45]/20 to-transparent"></div>

                            <div class="absolute inset-x-6 bottom-6 text-white">
                                <div class="flex flex-wrap gap-2">
                                    <span class="booking-type-badge rounded-full px-3.5 py-1.5 text-xs font-extrabold tracking-[0.02em]">
                                        {{ $room->roomType?->name ?? 'Phòng nghỉ' }}
                                    </span>
                                    <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $badgeClasses }} shadow-sm">
                                        {{ $statusText }}
                                    </span>
                                </div>

                                <p class="mt-5 text-xs font-semibold uppercase tracking-[0.18em] text-white/70">Phòng {{ $room->room_number }}</p>
                                <h2 class="mt-2 text-3xl font-black">
                                    {{ number_format($price, 0, ',', '.') }} đ
                                    <span class="text-lg font-semibold text-white/80">/ đêm</span>
                                </h2>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tại sao nên gửi yêu cầu từ đây?</p>
                            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                                Biểu mẫu ngắn gọn nhưng vẫn đủ thông tin để xử lý booking nhanh và chính xác.
                            </h2>

                            <div class="mt-6 space-y-4">
                                @foreach($benefits as $item)
                                    <div class="flex gap-3 rounded-[1.4rem] bg-slate-50 p-4">
                                        <div class="mt-1 text-[#173F8A]">✓</div>
                                        <p class="text-sm leading-7 text-slate-700">{{ $item }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 rounded-[1.5rem] border border-[#173F8A]/10 bg-[linear-gradient(135deg,rgba(23,63,138,0.05),rgba(46,196,182,0.08))] p-5">
                                <p class="text-sm font-semibold text-slate-900">Lưu ý liên hệ</p>
                                <p class="mt-2 text-sm leading-7 text-slate-700">
                                    {{ $contactHint }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 booking-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Thông tin đặt phòng</p>
                            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                                Hoàn tất thông tin khách hàng và lịch lưu trú
                            </h2>
                        </div>

                        <div class="booking-note-chip inline-flex rounded-full px-4 py-2 text-xs font-semibold text-slate-700">
                            Phòng tối đa {{ $capacity }} người
                        </div>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('public.bookings.store', $room) }}"
                        class="mt-8 space-y-8"
                        id="bookingForm"
                        data-room-price="{{ $price }}"
                        data-room-capacity="{{ $capacity }}"
                    >
                        @csrf

                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900">Thông tin khách hàng</h3>
                            <div class="mt-5 grid gap-5 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="booking-label">
                                        Họ và tên <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="full_name"
                                        value="{{ old('full_name') }}"
                                        class="booking-input"
                                        placeholder="Nhập họ và tên người đặt phòng"
                                    >
                                </div>

                                <div>
                                    <label class="booking-label">Số điện thoại</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        class="booking-input"
                                        placeholder="Nhập số điện thoại"
                                    >
                                </div>

                                <div>
                                    <label class="booking-label">Email</label>
                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="booking-input"
                                        placeholder="Nhập địa chỉ email"
                                    >
                                </div>

                                <div>
                                    <label class="booking-label">CCCD / CMND</label>
                                    <input
                                        type="text"
                                        name="identity_number"
                                        value="{{ old('identity_number') }}"
                                        class="booking-input"
                                        placeholder="Nhập CCCD / CMND"
                                    >
                                </div>

                                <div>
                                    <label class="booking-label">Địa chỉ</label>
                                    <input
                                        type="text"
                                        name="address"
                                        value="{{ old('address') }}"
                                        class="booking-input"
                                        placeholder="Nhập địa chỉ liên hệ"
                                    >
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900">Thông tin lưu trú</h3>

                            <div class="mt-5 grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="booking-label">
                                        Ngày nhận phòng <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="check_in_date"
                                        min="{{ $today }}"
                                        value="{{ old('check_in_date', $checkInDate) }}"
                                        class="booking-input"
                                        id="checkInDate"
                                    >
                                </div>

                                <div>
                                    <label class="booking-label">
                                        Ngày trả phòng <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        name="check_out_date"
                                        min="{{ old('check_in_date', $checkInDate ?: $today) }}"
                                        value="{{ old('check_out_date', $checkOutDate) }}"
                                        class="booking-input"
                                        id="checkOutDate"
                                    >
                                </div>

                                <div>
                                    <label class="booking-label">
                                        Người lớn <span class="text-rose-500">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        name="adults"
                                        min="1"
                                        value="{{ old('adults', 1) }}"
                                        class="booking-input"
                                        id="adultsInput"
                                    >
                                </div>

                                <div>
                                    <label class="booking-label">Trẻ em</label>
                                    <input
                                        type="number"
                                        name="children"
                                        min="0"
                                        value="{{ old('children', 0) }}"
                                        class="booking-input"
                                        id="childrenInput"
                                    >
                                </div>
                            </div>

                            <div
                                id="guestCapacityHint"
                                class="mt-5 rounded-[1.4rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600"
                            >
                                Tổng số khách hiện tại sẽ được đối chiếu với sức chứa tối đa của phòng là {{ $capacity }} người.
                            </div>
                        </div>

                        <div class="rounded-[1.6rem] border border-amber-200 bg-amber-50 p-5 text-sm leading-7 text-amber-900">
                            Sau khi gửi yêu cầu, booking sẽ được tạo với trạng thái <strong>pending</strong>. Bộ phận vận hành sẽ tiếp nhận và xác nhận lại theo tình trạng thực tế của phòng.
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <button
                                type="submit"
                                class="nav-btn-hover inline-flex rounded-full bg-[#173F8A] px-6 py-3 text-sm font-semibold text-white hover:bg-[#143374] hover:shadow-[0_14px_32px_rgba(23,63,138,0.18)]"
                            >
                                Gửi yêu cầu đặt phòng
                            </button>

                            <a
                                href="{{ route('public.rooms.show', array_filter([
                                    'room' => $room->id,
                                    'check_in_date' => old('check_in_date', $checkInDate),
                                    'check_out_date' => old('check_out_date', $checkOutDate),
                                ])) }}"
                                class="nav-btn-hover inline-flex rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                            >
                                Quay lại chi tiết phòng
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
                <div class="reveal-on-scroll reveal-delay-1 booking-shell-card rounded-[2rem] bg-white p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tạm tính booking</p>
                            <h2 class="mt-3 text-2xl font-black text-slate-900">Tóm tắt lưu trú</h2>
                        </div>

                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                            {{ $statusText }}
                        </span>
                    </div>

                    <div class="mt-6 rounded-[1.6rem] bg-slate-50 p-5">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Phòng</span>
                            <strong class="text-slate-900">{{ $room->room_number }}</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Loại phòng</span>
                            <strong class="text-slate-900">{{ $room->roomType?->name ?? 'Đang cập nhật' }}</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Giá / đêm</span>
                            <strong class="text-slate-900" id="roomPriceDisplay">{{ number_format($price, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Sức chứa tối đa</span>
                            <strong class="text-slate-900">{{ $capacity }} người</strong>
                        </div>
                    </div>

                    <div class="mt-5 space-y-3 text-sm text-slate-700">
                        <div class="flex items-center justify-between">
                            <span>Ngày nhận phòng</span>
                            <strong id="summaryCheckIn">{{ $formattedCheckIn ?: 'Chưa chọn' }}</strong>
                        </div>

                        <div class="flex items-center justify-between">
                            <span>Ngày trả phòng</span>
                            <strong id="summaryCheckOut">{{ $formattedCheckOut ?: 'Chưa chọn' }}</strong>
                        </div>

                        <div class="flex items-center justify-between">
                            <span>Số đêm</span>
                            <strong id="summaryNights">{{ $previewNights ? $previewNights . ' đêm' : '—' }}</strong>
                        </div>

                        <div class="flex items-center justify-between">
                            <span>Tổng khách</span>
                            <strong id="summaryGuests">{{ (int) old('adults', 1) + (int) old('children', 0) }} người</strong>
                        </div>

                        <div class="border-t border-slate-200 pt-3">
                            <div class="flex items-center justify-between text-base">
                                <span class="font-semibold text-slate-900">Tổng tiền dự kiến</span>
                                <strong class="text-lg text-slate-900" id="summaryTotal">
                                    {{ $previewTotal ? number_format($previewTotal, 0, ',', '.') . ' đ' : 'Chưa đủ dữ liệu' }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 booking-shell-card rounded-[2rem] bg-white p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Hỗ trợ trước khi gửi</p>
                    <div class="mt-4 space-y-4 text-sm leading-7 text-slate-600">
                        <p>• Điền chính xác số điện thoại hoặc email để thuận tiện tra cứu trạng thái booking.</p>
                        <p>• Nếu thay đổi ngày lưu trú, phần tạm tính bên phải sẽ cập nhật lại tự động.</p>
                        <p>• Khi tổng số khách vượt sức chứa, hệ thống sẽ cảnh báo để anh điều chỉnh trước khi gửi.</p>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-3 booking-shell-card rounded-[2rem] bg-[#081A45] p-6 text-white">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#9ff4ec]">Sau khi gửi booking</p>
                    <h3 class="mt-3 text-2xl font-black">Theo dõi lại trạng thái rất nhanh</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Khi booking được tiếp nhận, anh có thể dùng mã booking cùng số điện thoại hoặc email để tra cứu lại bất cứ lúc nào.
                    </p>
                    <a
                        href="{{ route('public.bookings.lookup') }}"
                        class="nav-btn-hover mt-6 inline-flex rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#081A45] hover:bg-slate-100"
                    >
                        Đi tới trang tra cứu
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

            const form = document.getElementById('bookingForm');
            if (!form) return;

            const roomPrice = parseInt(form.dataset.roomPrice || '0', 10);
            const roomCapacity = parseInt(form.dataset.roomCapacity || '0', 10);

            const checkInInput = document.getElementById('checkInDate');
            const checkOutInput = document.getElementById('checkOutDate');
            const adultsInput = document.getElementById('adultsInput');
            const childrenInput = document.getElementById('childrenInput');

            const summaryCheckIn = document.getElementById('summaryCheckIn');
            const summaryCheckOut = document.getElementById('summaryCheckOut');
            const summaryNights = document.getElementById('summaryNights');
            const summaryGuests = document.getElementById('summaryGuests');
            const summaryTotal = document.getElementById('summaryTotal');
            const guestCapacityHint = document.getElementById('guestCapacityHint');

            const fallbackMin = '{{ $today }}';

            function formatDate(date) {
                const y = date.getFullYear();
                const m = String(date.getMonth() + 1).padStart(2, '0');
                const d = String(date.getDate()).padStart(2, '0');
                return `${y}-${m}-${d}`;
            }

            function formatDisplayDate(value) {
                if (!value) return 'Chưa chọn';
                const parts = value.split('-');
                if (parts.length !== 3) return value;
                return `${parts[2]}/${parts[1]}/${parts[0]}`;
            }

            function formatMoney(value) {
                return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
            }

            function syncCheckoutMin() {
                if (!checkInInput.value) {
                    checkOutInput.min = fallbackMin;
                    return;
                }

                const minCheckout = new Date(checkInInput.value);
                minCheckout.setDate(minCheckout.getDate() + 1);

                const minCheckoutValue = formatDate(minCheckout);
                checkOutInput.min = minCheckoutValue;

                if (!checkOutInput.value || checkOutInput.value <= checkInInput.value) {
                    checkOutInput.value = minCheckoutValue;
                }
            }

            function updateGuestSummary() {
                const adults = parseInt(adultsInput.value || '0', 10);
                const children = parseInt(childrenInput.value || '0', 10);
                const totalGuests = Math.max(adults, 0) + Math.max(children, 0);

                summaryGuests.textContent = `${totalGuests} người`;

                if (totalGuests > roomCapacity && roomCapacity > 0) {
                    guestCapacityHint.className = 'mt-5 rounded-[1.4rem] border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700';
                    guestCapacityHint.textContent = `Tổng số khách hiện tại là ${totalGuests}, đang vượt sức chứa tối đa ${roomCapacity} người của phòng này.`;
                } else {
                    guestCapacityHint.className = 'mt-5 rounded-[1.4rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600';
                    guestCapacityHint.textContent = `Tổng số khách hiện tại sẽ được đối chiếu với sức chứa tối đa của phòng là ${roomCapacity} người.`;
                }
            }

            function updateStaySummary() {
                const checkIn = checkInInput.value;
                const checkOut = checkOutInput.value;

                summaryCheckIn.textContent = formatDisplayDate(checkIn);
                summaryCheckOut.textContent = formatDisplayDate(checkOut);

                if (!checkIn || !checkOut) {
                    summaryNights.textContent = '—';
                    summaryTotal.textContent = 'Chưa đủ dữ liệu';
                    return;
                }

                const start = new Date(checkIn);
                const end = new Date(checkOut);

                if (Number.isNaN(start.getTime()) || Number.isNaN(end.getTime()) || end <= start) {
                    summaryNights.textContent = '—';
                    summaryTotal.textContent = 'Chưa đủ dữ liệu';
                    return;
                }

                const diffDays = Math.round((end - start) / (1000 * 60 * 60 * 24));
                const nights = Math.max(diffDays, 1);
                const total = nights * roomPrice;

                summaryNights.textContent = `${nights} đêm`;
                summaryTotal.textContent = formatMoney(total);
            }

            function refreshAll() {
                syncCheckoutMin();
                updateStaySummary();
                updateGuestSummary();
            }

            refreshAll();

            checkInInput.addEventListener('change', refreshAll);
            checkOutInput.addEventListener('change', updateStaySummary);
            adultsInput.addEventListener('input', updateGuestSummary);
            childrenInput.addEventListener('input', updateGuestSummary);
        });
    </script>
</x-layouts.public>