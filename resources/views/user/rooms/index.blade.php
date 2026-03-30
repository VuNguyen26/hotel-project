@php
    use Carbon\Carbon;

    $today = now()->toDateString();

    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroBackground = $assetOrFallback(
        'images/user/rooms-hero.jpg',
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80'
    );

    $roomImages = [
        $assetOrFallback('images/user/featured-room-1.jpg', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1400&q=80'),
        $assetOrFallback('images/user/featured-room-2.jpg', 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1400&q=80'),
        $assetOrFallback('images/user/featured-room-3.jpg', 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1400&q=80'),
        $assetOrFallback('images/user/featured-room-4.jpg', 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1400&q=80'),
        $assetOrFallback('images/user/featured-room-5.jpg', 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1400&q=80'),
        $assetOrFallback('images/user/featured-room-6.jpg', 'https://images.unsplash.com/photo-1455587734955-081b22074882?auto=format&fit=crop&w=1400&q=80'),
    ];

    $formattedCheckIn = $checkInDate ? Carbon::parse($checkInDate)->format('d/m/Y') : null;
    $formattedCheckOut = $checkOutDate ? Carbon::parse($checkOutDate)->format('d/m/Y') : null;

    $activeFilterCount = collect([
        request('check_in_date'),
        request('check_out_date'),
        request('room_type_id'),
        request('capacity'),
        request('status'),
        request('sort') && request('sort') !== 'latest' ? request('sort') : null,
    ])->filter()->count();

    $selectedRoomTypeName = optional($roomTypes->firstWhere('id', (int) request('room_type_id')))->name;

    $activeFilters = array_filter([
        $formattedCheckIn && $formattedCheckOut ? 'Lưu trú: ' . $formattedCheckIn . ' - ' . $formattedCheckOut : null,
        $selectedRoomTypeName ? 'Loại phòng: ' . $selectedRoomTypeName : null,
        request('capacity') ? 'Sức chứa từ ' . request('capacity') . ' người' : null,
        request('status') ? 'Trạng thái: ' . match (request('status')) {
            'available' => 'Còn trống',
            'booked' => 'Đã được đặt',
            'occupied' => 'Đang sử dụng',
            default => ucfirst((string) request('status')),
        } : null,
        request('sort') && request('sort') !== 'latest' ? 'Sắp xếp: ' . match (request('sort')) {
            'price_asc' => 'Giá tăng dần',
            'price_desc' => 'Giá giảm dần',
            'room_number_asc' => 'Số phòng tăng dần',
            'room_number_desc' => 'Số phòng giảm dần',
            default => 'Mới nhất',
        } : null,
    ]);

    $heroStats = [
        ['label' => 'Phòng đang hiển thị', 'value' => number_format($rooms->total())],
        ['label' => 'Hạng phòng', 'value' => number_format($roomTypes->count())],
        ['label' => 'Bộ lọc đang áp dụng', 'value' => number_format($activeFilterCount)],
    ];
@endphp

<x-layouts.public
    title="Phòng nghỉ | Navara Boutique Hotel"
    metaDescription="Khám phá danh sách phòng tại Navara Boutique Hotel, lọc theo ngày lưu trú, loại phòng, sức chứa và đặt phòng nhanh chóng trong giao diện hiện đại, sang trọng."
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
            0%, 100% { transform: translateY(0px); }
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

        @keyframes scaleInSoft {
            0% {
                opacity: 0;
                transform: scale(0.965);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shineSweep {
            0% {
                transform: translateX(-130%) skewX(-18deg);
                opacity: 0;
            }
            20% {
                opacity: .22;
            }
            100% {
                transform: translateX(220%) skewX(-18deg);
                opacity: 0;
            }
        }

        .rooms-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .rooms-filter-card {
            align-self: start;
        }

        .room-card {
            position: relative;
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        }

        .room-card:hover {
            transform: translateY(-8px);
            border-color: rgba(23, 63, 138, 0.16);
            box-shadow: var(--navara-shadow-lg);
        }

        .room-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,.06) 45%, rgba(255,255,255,.22) 50%, transparent 55%);
            transform: translateX(-130%) skewX(-18deg);
            pointer-events: none;
            z-index: 2;
        }

        .room-card:hover::after {
            animation: shineSweep .9s ease;
        }

        .room-card img {
            transition: transform .8s ease;
        }

        .room-card:hover img {
            transform: scale(1.06);
        }

        .room-type-badge {
            background: rgba(255, 255, 255, 0.98);
            color: #0B245B;
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 14px 32px rgba(8, 26, 69, 0.22);
        }

        .room-status-badge {
            box-shadow: 0 10px 24px rgba(8, 26, 69, 0.16);
        }

        .room-chip {
            border: 1px solid rgba(23, 63, 138, 0.08);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(8px);
        }

        .rooms-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .rooms-hero {
            position: relative;
            overflow: hidden;
            color: white;
            background-image:
                linear-gradient(
                    90deg,
                    rgba(8, 26, 69, 0.64) 0%,
                    rgba(8, 26, 69, 0.52) 34%,
                    rgba(13, 37, 92, 0.44) 68%,
                    rgba(13, 37, 92, 0.28) 100%
                ),
                url('{{ $heroBackground }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .rooms-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(46, 196, 182, 0.12), transparent 24%),
                linear-gradient(to top, rgba(8, 26, 69, 0.16), rgba(8, 26, 69, 0.02));
            pointer-events: none;
        }

        .rooms-hero-panel {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(9, 26, 64, 0.14);
            box-shadow: 0 28px 70px rgba(5, 15, 40, 0.18);
            backdrop-filter: blur(8px);
        }

        .rooms-hero-inner-card {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(8, 26, 69, 0.16);
        }

        .rooms-hero-stat {
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(8px);
        }

        .rooms-hero-badge {
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
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
            .rooms-floating-orb,
            .hero-copy-reveal,
            .hero-panel-reveal,
            .hero-stats-reveal,
            .reveal-on-scroll,
            .reveal-on-scroll.is-visible,
            .room-card::after,
            .room-card img,
            .nav-btn-hover,
            .room-card {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>

    <section class="rooms-hero min-h-[720px] lg:min-h-[760px]">
        <div class="absolute -left-16 top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl rooms-floating-orb"></div>
        <div class="absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl rooms-floating-orb"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="hero-copy-reveal">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">Phòng nghỉ</span>
                    </div>

                    <div class="mt-6 inline-flex rooms-hero-badge rounded-full px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.28em] text-[#9ff4ec]">
                        Bộ sưu tập phòng nghỉ Navara
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[4rem] lg:leading-[1.04]">
                        Tìm hạng phòng phù hợp cho lịch trình công tác hoặc nghỉ dưỡng của bạn.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        Dễ dàng lọc phòng theo ngày lưu trú, sức chứa và mức giá để chọn đúng không gian phù hợp. Mọi thông tin được trình bày rõ ràng, hiện đại và nhất quán với trải nghiệm tổng thể của website.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="#room-listing"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Xem danh sách phòng
                        </a>

                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Tra cứu booking
                        </a>
                    </div>
                </div>

                <div class="hero-panel-reveal rooms-hero-panel overflow-hidden rounded-[2rem] p-4 sm:p-5 lg:p-6">
                    <div class="rooms-hero-inner-card rounded-[1.75rem] p-6 text-slate-900 sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tìm phòng nhanh</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">Chọn ngày để hệ thống lọc chính xác</h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Phù hợp cho</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">Công tác · Nghỉ dưỡng · Gia đình</p>
                            </div>
                        </div>

                        @if($hasDateSearch)
                            <div class="mt-6 rounded-[1.5rem] border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em]">Khoảng ngày đã chọn</p>
                                <p class="mt-2 text-base font-bold">
                                    {{ $formattedCheckIn }} → {{ $formattedCheckOut }}
                                </p>
                            </div>
                        @elseif($dateSearchError)
                            <div class="mt-6 rounded-[1.5rem] border border-rose-200 bg-rose-50 p-4 text-rose-700">
                                <p class="text-sm font-semibold">{{ $dateSearchError }}</p>
                            </div>
                        @else
                            <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-slate-700">
                                <p class="text-sm leading-7">
                                    Chọn ngày nhận và trả phòng để ưu tiên hiển thị những phòng còn trống theo đúng lịch lưu trú bạn cần.
                                </p>
                            </div>
                        @endif

                        <div class="mt-6 grid gap-3 sm:grid-cols-3">
                            @foreach($heroStats as $stat)
                                <div class="hero-stats-reveal rooms-hero-stat rounded-[1.4rem] p-4" style="animation-delay: {{ 0.28 + ($loop->index * 0.08) }}s;">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $stat['label'] }}</p>
                                    <p class="mt-3 text-2xl font-black text-slate-900">{{ $stat['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="room-listing" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-8 xl:grid-cols-[340px_minmax(0,1fr)] xl:items-start">
            <aside class="flex flex-col gap-6 self-start">
                <div class="rooms-shell-card rooms-filter-card rounded-[2rem] bg-white p-6 sm:p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tìm kiếm & lọc</p>
                            <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">Tối ưu kết quả theo nhu cầu lưu trú</h2>
                        </div>

                        @if($activeFilterCount > 0)
                            <span class="rounded-full bg-[#173F8A]/8 px-3 py-1 text-xs font-bold text-[#173F8A]">
                                {{ $activeFilterCount }} bộ lọc
                            </span>
                        @endif
                    </div>

                    <form method="GET" action="{{ route('public.rooms.index') }}" class="mt-7 space-y-5">
                        <div class="rounded-[1.75rem] border border-[#173F8A]/10 bg-[linear-gradient(135deg,rgba(23,63,138,0.05),rgba(46,196,182,0.08))] p-5">
                            <div class="flex items-start gap-3">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-[#173F8A] shadow-sm">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 2v4M16 2v4M3 10h18M5 6h14a2 2 0 0 1 2 2v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V8a2 2 0 0 1 2-2Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-slate-900">Kiểm tra phòng trống theo ngày</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-600">
                                        Kết quả sẽ loại những phòng đang có booking trùng khoảng thời gian bạn chọn.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 grid gap-4">
                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày nhận phòng</label>
                                    <input
                                        type="date"
                                        name="check_in_date"
                                        min="{{ $today }}"
                                        value="{{ request('check_in_date') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-[#173F8A] focus:outline-none focus:ring-4 focus:ring-[#173F8A]/10"
                                    >
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày trả phòng</label>
                                    <input
                                        type="date"
                                        name="check_out_date"
                                        min="{{ request('check_in_date') ?: $today }}"
                                        value="{{ request('check_out_date') }}"
                                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-[#173F8A] focus:outline-none focus:ring-4 focus:ring-[#173F8A]/10"
                                    >
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Loại phòng</label>
                            <select
                                name="room_type_id"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-[#173F8A] focus:outline-none focus:ring-4 focus:ring-[#173F8A]/10"
                            >
                                <option value="">Tất cả loại phòng</option>
                                @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}" @selected(request('room_type_id') == $roomType->id)>
                                        {{ $roomType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-1">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Sức chứa tối thiểu</label>
                                <select
                                    name="capacity"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-[#173F8A] focus:outline-none focus:ring-4 focus:ring-[#173F8A]/10"
                                >
                                    <option value="">Không giới hạn</option>
                                    <option value="1" @selected(request('capacity') == '1')>Từ 1 người</option>
                                    <option value="2" @selected(request('capacity') == '2')>Từ 2 người</option>
                                    <option value="3" @selected(request('capacity') == '3')>Từ 3 người</option>
                                    <option value="4" @selected(request('capacity') == '4')>Từ 4 người</option>
                                    <option value="5" @selected(request('capacity') == '5')>Từ 5 người</option>
                                </select>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">Trạng thái hiện tại</label>
                                <select
                                    name="status"
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-[#173F8A] focus:outline-none focus:ring-4 focus:ring-[#173F8A]/10"
                                >
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="available" @selected(request('status') == 'available')>Còn trống</option>
                                    <option value="booked" @selected(request('status') == 'booked')>Đã được đặt</option>
                                    <option value="occupied" @selected(request('status') == 'occupied')>Đang sử dụng</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Sắp xếp</label>
                            <select
                                name="sort"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-[#173F8A] focus:outline-none focus:ring-4 focus:ring-[#173F8A]/10"
                            >
                                <option value="latest" @selected(request('sort', 'latest') == 'latest')>Mới nhất</option>
                                <option value="price_asc" @selected(request('sort') == 'price_asc')>Giá tăng dần</option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>Giá giảm dần</option>
                                <option value="room_number_asc" @selected(request('sort') == 'room_number_asc')>Số phòng tăng dần</option>
                                <option value="room_number_desc" @selected(request('sort') == 'room_number_desc')>Số phòng giảm dần</option>
                            </select>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button
                                type="submit"
                                class="nav-btn-hover flex-1 rounded-full bg-[#173F8A] px-5 py-3 text-sm font-semibold text-white hover:bg-[#143374] hover:shadow-[0_14px_32px_rgba(23,63,138,0.18)]"
                            >
                                Tìm phòng
                            </button>

                            <a
                                href="{{ route('public.rooms.index') }}"
                                class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                            >
                                Làm mới
                            </a>
                        </div>
                    </form>
                </div>

                <div class="rooms-shell-card rounded-[2rem] bg-white p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Gợi ý lựa chọn</p>
                    <div class="mt-4 space-y-4 text-sm leading-7 text-slate-600">
                        <p>
                            Với chuyến đi ngắn ngày, hãy ưu tiên lọc theo khoảng ngày trước để thấy đúng các phòng còn trống thực tế.
                        </p>
                        <p>
                            Nếu đi theo nhóm hoặc gia đình, nên chọn sức chứa tối thiểu từ 3 đến 4 người để rút gọn danh sách phù hợp hơn.
                        </p>
                    </div>

                    <div class="mt-6 grid gap-3">
                        <a
                            href="{{ route('home') }}#booking-search"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                        >
                            Quay lại tìm kiếm nhanh ở trang chủ
                        </a>
                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full bg-[#2EC4B6] px-4 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Tra cứu booking đã gửi
                        </a>
                    </div>
                </div>
            </aside>

            <div class="space-y-6">
                <div class="reveal-on-scroll reveal-delay-1 rooms-shell-card rounded-[2rem] bg-white p-6 sm:p-7">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Danh sách phòng</p>
                            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                                {{ number_format($rooms->total()) }} lựa chọn phù hợp với bộ lọc hiện tại
                            </h2>
                            <p class="mt-3 text-sm leading-7 text-slate-600">
                                Đang hiển thị từ {{ $rooms->firstItem() ?? 0 }} đến {{ $rooms->lastItem() ?? 0 }} trong tổng số {{ number_format($rooms->total()) }} phòng.
                            </p>
                        </div>

                        <a
                            href="{{ route('home') }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                        >
                            ← Về trang chủ
                        </a>
                    </div>

                    @if(!empty($activeFilters))
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach($activeFilters as $filter)
                                <span class="room-chip inline-flex rounded-full px-4 py-2 text-xs font-semibold text-slate-700">
                                    {{ $filter }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if($rooms->count() > 0)
                    <div class="grid gap-6 md:grid-cols-2 2xl:grid-cols-3">
                        @foreach($rooms as $index => $room)
                            @php
                                $statusConfig = $hasDateSearch
                                    ? ['class' => 'bg-emerald-100 text-emerald-700', 'label' => 'Trống theo ngày đã chọn']
                                    : match($room->status) {
                                        'available' => ['class' => 'bg-emerald-100 text-emerald-700', 'label' => 'Còn trống'],
                                        'booked' => ['class' => 'bg-amber-100 text-amber-700', 'label' => 'Đã được đặt'],
                                        'occupied' => ['class' => 'bg-rose-100 text-rose-700', 'label' => 'Đang sử dụng'],
                                        default => ['class' => 'bg-slate-100 text-slate-700', 'label' => ucfirst((string) $room->status)],
                                    };

                                $price = (int) ($room->roomType?->price ?? 0);
                                $capacity = (int) ($room->roomType?->capacity ?? 0);
                                $roomImage = $roomImages[($room->id + $index) % count($roomImages)];

                                $detailParams = array_filter([
                                    'room' => $room->id,
                                    'check_in_date' => request('check_in_date'),
                                    'check_out_date' => request('check_out_date'),
                                ]);

                                $bookParams = array_filter([
                                    'room' => $room->id,
                                    'check_in_date' => request('check_in_date'),
                                    'check_out_date' => request('check_out_date'),
                                ]);
                            @endphp

                            <article class="room-card reveal-on-scroll overflow-hidden rounded-[2rem] bg-white" style="animation-delay: {{ 0.04 * $loop->index }}s;">
                                <div class="relative overflow-hidden">
                                    <img
                                        src="{{ $roomImage }}"
                                        alt="Phòng {{ $room->room_number }}"
                                        class="h-64 w-full object-cover"
                                        loading="lazy"
                                    >

                                    <div class="absolute inset-0 bg-gradient-to-t from-[#081A45]/75 via-[#081A45]/18 to-transparent"></div>

                                    <div class="absolute left-5 top-5 z-[3] flex flex-wrap gap-2">
                                        <span class="room-type-badge rounded-full px-3.5 py-1.5 text-xs font-extrabold tracking-[0.02em]">
                                            {{ $room->roomType?->name ?? 'Phòng nghỉ' }}
                                        </span>
                                        <span class="room-status-badge rounded-full px-3 py-1.5 text-xs font-bold {{ $statusConfig['class'] }}">
                                            {{ $statusConfig['label'] }}
                                        </span>
                                    </div>

                                    <div class="absolute inset-x-5 bottom-5 z-[3] flex items-end justify-between gap-4 text-white">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/70">Phòng {{ $room->room_number }}</p>
                                            <h3 class="mt-2 text-2xl font-black tracking-tight">{{ number_format($price, 0, ',', '.') }} đ<span class="text-base font-semibold text-white/80"> / đêm</span></h3>
                                        </div>
                                        <div class="rounded-2xl border border-white/15 bg-white/10 px-3 py-2 text-right backdrop-blur-sm">
                                            <p class="text-[11px] uppercase tracking-[0.18em] text-white/70">Sức chứa</p>
                                            <p class="mt-1 text-sm font-bold">{{ $capacity }} người</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <div class="grid gap-3 sm:grid-cols-3">
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Loại phòng</p>
                                            <p class="mt-2 text-sm font-bold text-slate-900">{{ $room->roomType?->name ?? 'Đang cập nhật' }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Tầng</p>
                                            <p class="mt-2 text-sm font-bold text-slate-900">{{ $room->floor ?? 'Đang cập nhật' }}</p>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Mã phòng</p>
                                            <p class="mt-2 text-sm font-bold text-slate-900">#{{ $room->id }}</p>
                                        </div>
                                    </div>

                                    <p class="mt-5 text-sm leading-7 text-slate-600">
                                        {{ \Illuminate\Support\Str::limit($room->roomType?->description ?: 'Không gian lưu trú được thiết kế theo hướng chỉn chu, hiện đại và phù hợp cho cả khách công tác lẫn nghỉ dưỡng ngắn ngày.', 145) }}
                                    </p>

                                    @if($hasDateSearch)
                                        <div class="mt-5 rounded-[1.4rem] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                                            Phòng này hiện trống trong khoảng {{ $formattedCheckIn }} → {{ $formattedCheckOut }}.
                                        </div>
                                    @endif

                                    <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <a
                                            href="{{ route('public.rooms.show', $detailParams) }}"
                                            class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                                        >
                                            Xem chi tiết
                                        </a>

                                        <a
                                            href="{{ route('public.bookings.create', $bookParams) }}"
                                            class="nav-btn-hover inline-flex items-center justify-center rounded-full bg-[#173F8A] px-5 py-3 text-sm font-semibold text-white hover:bg-[#143374] hover:shadow-[0_14px_32px_rgba(23,63,138,0.18)]"
                                        >
                                            Đặt phòng ngay
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="reveal-on-scroll reveal-delay-2 rooms-shell-card rounded-[2rem] bg-white px-4 py-4 sm:px-6">
                        {{ $rooms->links() }}
                    </div>
                @else
                    <div class="reveal-on-scroll rooms-shell-card overflow-hidden rounded-[2rem] bg-white">
                        <div class="grid gap-0 lg:grid-cols-[0.95fr_1.05fr]">
                            <div class="relative min-h-[280px] overflow-hidden bg-[#081A45]">
                                <img
                                    src="{{ $roomImages[1] }}"
                                    alt="Không gian phòng nghỉ"
                                    class="h-full w-full object-cover opacity-40"
                                >
                                <div class="absolute inset-0 bg-gradient-to-br from-[#081A45]/75 via-[#173F8A]/50 to-[#2EC4B6]/25"></div>
                                <div class="absolute inset-0 flex items-end p-8 text-white">
                                    <div>
                                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">Không tìm thấy lựa chọn phù hợp</p>
                                        <h3 class="mt-4 max-w-md text-3xl font-black tracking-tight">
                                            Hãy điều chỉnh ngày lưu trú hoặc giảm bớt bộ lọc để mở rộng kết quả.
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8 sm:p-10">
                                <div class="max-w-xl">
                                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Gợi ý tiếp theo</p>
                                    <div class="mt-5 space-y-4 text-sm leading-7 text-slate-600">
                                        @if($hasDateSearch)
                                            <p>
                                                Không có phòng trống trong đúng khoảng {{ $formattedCheckIn }} → {{ $formattedCheckOut }}. Anh có thể thử đổi ngày nhận phòng, lùi hoặc rút ngắn thời gian lưu trú để tăng số lựa chọn.
                                            </p>
                                        @else
                                            <p>
                                                Hiện chưa có phòng phù hợp với bộ lọc đang chọn. Hãy làm mới bộ lọc để xem đầy đủ tất cả các phòng đang mở bán trên hệ thống.
                                            </p>
                                        @endif
                                        <p>
                                            Nếu đã gửi booking trước đó, anh cũng có thể vào khu vực tra cứu để kiểm tra lại trạng thái xác nhận và thanh toán.
                                        </p>
                                    </div>

                                    <div class="mt-8 flex flex-wrap gap-3">
                                        <a
                                            href="{{ route('public.rooms.index') }}"
                                            class="nav-btn-hover inline-flex rounded-full bg-[#173F8A] px-5 py-3 text-sm font-semibold text-white hover:bg-[#143374]"
                                        >
                                            Xem tất cả phòng
                                        </a>
                                        <a
                                            href="{{ route('public.bookings.lookup') }}"
                                            class="nav-btn-hover inline-flex rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                                        >
                                            Tra cứu booking
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
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