@php
    use Carbon\Carbon;

    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroBackground = $assetOrFallback(
        'images/user/booking-result-hero.jpg',
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80'
    );

    $coverImage = $assetOrFallback(
        'images/user/booking-result-cover.jpg',
        'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1600&q=80'
    );

    $statusText = match($booking->status) {
        'pending' => 'Chờ xác nhận',
        'confirmed' => 'Đã xác nhận',
        'checked_in' => 'Đã check-in',
        'checked_out' => 'Đã check-out',
        'cancelled' => 'Đã hủy',
        default => ucfirst((string) $booking->status),
    };

    $statusBadge = match($booking->status) {
        'pending' => 'bg-amber-100 text-amber-700',
        'confirmed' => 'bg-sky-100 text-sky-700',
        'checked_in' => 'bg-emerald-100 text-emerald-700',
        'checked_out' => 'bg-slate-100 text-slate-700',
        'cancelled' => 'bg-rose-100 text-rose-700',
        default => 'bg-slate-100 text-slate-700',
    };

    if ($paidAmount <= 0) {
        $paymentText = 'Chưa thanh toán';
        $paymentBadge = 'bg-rose-100 text-rose-700';
    } elseif ($remainingAmount > 0) {
        $paymentText = 'Đã thanh toán một phần';
        $paymentBadge = 'bg-amber-100 text-amber-700';
    } else {
        $paymentText = 'Đã thanh toán đủ';
        $paymentBadge = 'bg-emerald-100 text-emerald-700';
    }

    $checkIn = Carbon::parse($booking->check_in_date);
    $checkOut = Carbon::parse($booking->check_out_date);
    $nights = max($checkIn->diffInDays($checkOut), 1);

    $capacity = (int) (($booking->adults ?? 0) + ($booking->children ?? 0));
    $roomPrice = $nights > 0 ? ((float) $booking->total_price / $nights) : 0;

    $heroStats = [
        ['label' => 'Tổng tiền booking', 'value' => number_format((float) $booking->total_price, 0, ',', '.') . ' đ'],
        ['label' => 'Đã thanh toán', 'value' => number_format((float) $paidAmount, 0, ',', '.') . ' đ'],
        ['label' => 'Còn lại', 'value' => number_format((float) $remainingAmount, 0, ',', '.') . ' đ'],
    ];

    $timeline = [
        [
            'title' => 'Tạo booking',
            'desc' => 'Yêu cầu đặt phòng đã được ghi nhận vào hệ thống.',
            'active' => true,
        ],
        [
            'title' => 'Xác nhận booking',
            'desc' => 'Bộ phận vận hành sẽ kiểm tra và cập nhật trạng thái phù hợp.',
            'active' => in_array($booking->status, ['confirmed', 'checked_in', 'checked_out'], true),
        ],
        [
            'title' => 'Lưu trú',
            'desc' => 'Booking chuyển sang giai đoạn check-in / check-out theo vận hành thực tế.',
            'active' => in_array($booking->status, ['checked_in', 'checked_out'], true),
        ],
    ];

    $paymentMethodText = function ($method) {
        return match ($method) {
            'cash' => 'Tiền mặt',
            'bank_transfer' => 'Chuyển khoản',
            'card' => 'Thẻ',
            default => $method ? ucfirst((string) $method) : 'Chưa cập nhật',
        };
    };

    $infoCards = [
        [
            'label' => 'Khách hàng',
            'value' => $booking->customer?->full_name ?: 'Đang cập nhật',
            'sub' => trim(($booking->customer?->phone ?: 'Chưa có số điện thoại') . ' · ' . ($booking->customer?->email ?: 'Chưa có email')),
        ],
        [
            'label' => 'Phòng',
            'value' => 'Phòng ' . ($booking->room?->room_number ?: 'N/A'),
            'sub' => trim(($booking->room?->roomType?->name ?: 'Đang cập nhật') . ' · Tầng ' . ($booking->room?->floor ?? 'N/A')),
        ],
        [
            'label' => 'Lịch lưu trú',
            'value' => $checkIn->format('d/m/Y') . ' → ' . $checkOut->format('d/m/Y'),
            'sub' => $nights . ' đêm · ' . $capacity . ' khách',
        ],
        [
            'label' => 'Ngày tạo booking',
            'value' => $booking->created_at?->format('d/m/Y H:i') ?: 'Chưa cập nhật',
            'sub' => 'Mã booking: ' . $bookingCode,
        ],
    ];

    $statusNotes = [
        'pending' => 'Booking đã được tiếp nhận và đang chờ xác nhận từ bộ phận vận hành.',
        'confirmed' => 'Booking đã được xác nhận và sẵn sàng cho lịch lưu trú đã chọn.',
        'checked_in' => 'Khách đã nhận phòng theo booking này.',
        'checked_out' => 'Booking đã hoàn tất lưu trú.',
        'cancelled' => 'Booking đã bị hủy hoặc không còn hiệu lực.',
    ];

    $currentStatusNote = $statusNotes[$booking->status] ?? 'Trạng thái booking đang được cập nhật theo hệ thống.';
@endphp

<x-layouts.public
    title="Kết quả tra cứu {{ $bookingCode }} | Navara Boutique Hotel"
    metaDescription="Xem kết quả tra cứu booking {{ $bookingCode }} tại Navara Boutique Hotel, bao gồm trạng thái booking, lịch lưu trú và thông tin thanh toán."
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

        .result-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .result-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .result-chip {
            border: 1px solid rgba(23, 63, 138, 0.08);
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(6px);
        }

        .result-table-wrap {
            overflow-x: auto;
        }

        .result-hero {
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

        .result-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(46, 196, 182, 0.12), transparent 24%),
                linear-gradient(to top, rgba(8, 26, 69, 0.16), rgba(8, 26, 69, 0.02));
            pointer-events: none;
        }

        .result-hero-badge {
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
        }

        .result-hero-panel {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(9, 26, 64, 0.14);
            box-shadow: 0 28px 70px rgba(5, 15, 40, 0.18);
            backdrop-filter: blur(8px);
        }

        .result-hero-inner-card {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(8, 26, 69, 0.16);
        }

        .result-type-badge {
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
            .result-floating-orb,
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

    <section class="result-hero min-h-[700px] lg:min-h-[760px]">
        <div class="result-floating-orb absolute -left-16 top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        <div class="result-floating-orb absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="hero-copy-reveal">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <a href="{{ route('public.bookings.lookup') }}" class="transition hover:text-white">Tra cứu booking</a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">{{ $bookingCode }}</span>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <span class="result-hero-badge rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">
                            Kết quả tra cứu booking
                        </span>
                        <span class="rounded-full px-4 py-2 text-xs font-bold {{ $statusBadge }}">
                            {{ $statusText }}
                        </span>
                        <span class="rounded-full px-4 py-2 text-xs font-bold {{ $paymentBadge }}">
                            {{ $paymentText }}
                        </span>
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[3.9rem] lg:leading-[1.04]">
                        Booking {{ $bookingCode }} đã được tìm thấy và hiển thị đầy đủ thông tin cần theo dõi.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        Anh có thể xem lại trạng thái booking, phòng đã chọn, lịch lưu trú và phần thanh toán đã được ghi nhận ngay trên một màn hình duy nhất.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="#booking-result-detail"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Xem chi tiết booking
                        </a>

                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Tra cứu booking khác
                        </a>
                    </div>
                </div>

                <div class="hero-panel-reveal result-hero-panel overflow-hidden rounded-[2rem] p-4 sm:p-5 lg:p-6">
                    <div class="result-hero-inner-card rounded-[1.75rem] p-6 text-slate-900 sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tóm tắt nhanh</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                                    Theo dõi tiến độ xử lý booking
                                </h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Mã booking</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">{{ $bookingCode }}</p>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3">
                            @foreach($heroStats as $stat)
                                <div class="hero-stats-reveal rounded-[1.4rem] border border-slate-200 bg-white p-4" style="animation-delay: {{ 0.28 + ($loop->index * 0.08) }}s;">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $stat['label'] }}</p>
                                    <p class="mt-2 text-lg font-black text-slate-900">{{ $stat['value'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                            {{ $currentStatusNote }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="booking-result-detail" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-8">
                <div class="reveal-on-scroll reveal-delay-1 result-shell-card overflow-hidden rounded-[2rem] bg-white">
                    <div class="grid gap-0 lg:grid-cols-[0.92fr_1.08fr]">
                        <div class="relative min-h-[320px] overflow-hidden">
                            <img
                                src="{{ $coverImage }}"
                                alt="Booking {{ $bookingCode }}"
                                class="h-full w-full object-cover"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#081A45]/80 via-[#081A45]/20 to-transparent"></div>

                            <div class="absolute inset-x-6 bottom-6 text-white">
                                <div class="flex flex-wrap gap-2">
                                    <span class="result-type-badge rounded-full px-3.5 py-1.5 text-xs font-extrabold tracking-[0.02em]">
                                        {{ $booking->room?->roomType?->name ?? 'Phòng nghỉ' }}
                                    </span>
                                    <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $statusBadge }} shadow-sm">
                                        {{ $statusText }}
                                    </span>
                                </div>

                                <p class="mt-5 text-xs font-semibold uppercase tracking-[0.18em] text-white/70">
                                    Phòng {{ $booking->room?->room_number ?? 'N/A' }}
                                </p>
                                <h2 class="mt-2 text-3xl font-black">
                                    {{ $checkIn->format('d/m/Y') }} → {{ $checkOut->format('d/m/Y') }}
                                </h2>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Thông tin booking</p>
                            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                                Mọi thông tin quan trọng đã được gom lại rõ ràng trên một màn hình.
                            </h2>

                            <div class="mt-8 grid gap-4 md:grid-cols-2">
                                @foreach($infoCards as $card)
                                    <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $card['label'] }}</p>
                                        <p class="mt-3 text-lg font-black text-slate-900">{{ $card['value'] }}</p>
                                        <p class="mt-2 text-sm leading-7 text-slate-600">{{ $card['sub'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 result-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tiến độ xử lý</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Booking đang ở giai đoạn nào?
                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-3">
                        @foreach($timeline as $item)
                            <div class="rounded-[1.6rem] border p-5 {{ $item['active'] ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-slate-50' }}">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-bold {{ $item['active'] ? 'text-emerald-800' : 'text-slate-900' }}">
                                        {{ $item['title'] }}
                                    </p>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $item['active'] ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                        {{ $item['active'] ? 'Đã đạt' : 'Chưa tới' }}
                                    </span>
                                </div>
                                <p class="mt-3 text-sm leading-7 {{ $item['active'] ? 'text-emerald-800/90' : 'text-slate-600' }}">
                                    {{ $item['desc'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 result-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Chi tiết lưu trú</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Tóm tắt phòng, lịch ở và khách lưu trú
                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Loại phòng</p>
                            <p class="mt-3 text-lg font-black text-slate-900">{{ $booking->room?->roomType?->name ?? 'Đang cập nhật' }}</p>
                        </div>

                        <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Giá trung bình / đêm</p>
                            <p class="mt-3 text-lg font-black text-slate-900">{{ number_format($roomPrice, 0, ',', '.') }} đ</p>
                        </div>

                        <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Số đêm</p>
                            <p class="mt-3 text-lg font-black text-slate-900">{{ $nights }} đêm</p>
                        </div>

                        <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Số khách</p>
                            <p class="mt-3 text-lg font-black text-slate-900">
                                {{ $booking->adults }} người lớn{{ (int) $booking->children > 0 ? ', ' . $booking->children . ' trẻ em' : '' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-3 result-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Lịch sử thanh toán</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Các khoản thanh toán đã được ghi nhận
                    </h2>

                    @if($booking->payments->isNotEmpty())
                        <div class="result-table-wrap mt-8 overflow-hidden rounded-[1.8rem] border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Mã phiếu</th>
                                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Ngày thanh toán</th>
                                        <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Phương thức</th>
                                        <th class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Số tiền</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @foreach($booking->payments as $payment)
                                        <tr class="hover:bg-slate-50/80">
                                            <td class="px-5 py-4 text-sm font-bold text-slate-900">
                                                #{{ $payment->id }}
                                            </td>
                                            <td class="px-5 py-4 text-sm text-slate-600">
                                                {{ $payment->paid_at ? Carbon::parse($payment->paid_at)->format('d/m/Y H:i') : 'Chưa cập nhật' }}
                                            </td>
                                            <td class="px-5 py-4 text-sm text-slate-600">
                                                {{ $paymentMethodText($payment->payment_method) }}
                                            </td>
                                            <td class="px-5 py-4 text-right text-sm font-bold text-slate-900">
                                                {{ number_format((float) $payment->amount, 0, ',', '.') }} đ
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="mt-8 rounded-[1.8rem] border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-sm leading-7 text-slate-500">
                            Booking này hiện chưa có giao dịch thanh toán nào được ghi nhận trên hệ thống.
                        </div>
                    @endif
                </div>
            </div>

            <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
                <div class="reveal-on-scroll reveal-delay-1 result-shell-card rounded-[2rem] bg-white p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tóm tắt thanh toán</p>
                            <h2 class="mt-3 text-2xl font-black text-slate-900">Theo dõi công nợ hiện tại</h2>
                        </div>

                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $paymentBadge }}">
                            {{ $paymentText }}
                        </span>
                    </div>

                    <div class="mt-6 rounded-[1.6rem] bg-slate-50 p-5">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Tổng tiền booking</span>
                            <strong class="text-slate-900">{{ number_format((float) $booking->total_price, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Đã thanh toán</span>
                            <strong class="text-slate-900">{{ number_format((float) $paidAmount, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="mt-4 border-t border-slate-200 pt-4">
                            <div class="flex items-center justify-between text-base">
                                <span class="font-semibold text-slate-900">Còn lại</span>
                                <strong class="text-lg text-slate-900">{{ number_format((float) $remainingAmount, 0, ',', '.') }} đ</strong>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                        Tình trạng thanh toán hiển thị theo các khoản đã được ghi nhận trong hệ thống tại thời điểm anh tra cứu.
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 result-shell-card rounded-[2rem] border border-sky-200 bg-sky-50 p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-800">Mã booking của anh</p>
                    <h3 class="mt-3 text-2xl font-black text-sky-900">{{ $bookingCode }}</h3>
                    <p class="mt-4 text-sm leading-7 text-sky-900/85">
                        Hãy lưu lại mã này để tiếp tục tra cứu ở những lần sau hoặc đối chiếu khi làm việc với bộ phận vận hành.
                    </p>
                </div>

                <div class="reveal-on-scroll reveal-delay-3 result-shell-card rounded-[2rem] bg-white p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Hành động tiếp theo</p>
                    <div class="mt-5 grid gap-3">
                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full bg-[#173F8A] px-5 py-3 text-sm font-semibold text-white hover:bg-[#143374]"
                        >
                            Tra cứu booking khác
                        </a>

                        <a
                            href="{{ route('public.rooms.show', ['room' => $booking->room_id]) }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                        >
                            Xem lại chi tiết phòng
                        </a>

                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                        >
                            Khám phá thêm phòng nghỉ
                        </a>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-4 result-shell-card rounded-[2rem] bg-[#081A45] p-6 text-white">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#9ff4ec]">Thông tin hữu ích</p>
                    <h3 class="mt-3 text-2xl font-black">Muốn gửi booking mới?</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Anh có thể quay lại danh sách phòng để lọc theo ngày, loại phòng hoặc sức chứa rồi gửi yêu cầu mới ngay trên website.
                    </p>
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="nav-btn-hover mt-6 inline-flex rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#081A45] hover:bg-slate-100"
                    >
                        Đi tới danh sách phòng
                    </a>
                </div>
            </aside>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const revealItems = document.querySelectorAll('.reveal-on-scroll');

            if (!revealItems.length) return;

            const revealNow = (el) => {
                if (!el.classList.contains('is-visible')) {
                    el.classList.add('is-visible');
                }
            };

            if (!('IntersectionObserver' in window)) {
                revealItems.forEach(revealNow);
                return;
            }

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
        });
    </script>
</x-layouts.public>