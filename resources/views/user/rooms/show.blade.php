@php
    use Carbon\Carbon;

    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroBackground = $assetOrFallback(
        'images/user/room-detail-hero.jpg',
        'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1800&q=80'
    );

    $galleryImages = [
        $assetOrFallback('images/user/room-detail-1.jpg', 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1600&q=80'),
        $assetOrFallback('images/user/room-detail-2.jpg', 'https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-detail-3.jpg', 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-detail-4.jpg', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-detail-5.jpg', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80'),
    ];

    $checkInDate = request('check_in_date');
    $checkOutDate = request('check_out_date');
    $today = now()->toDateString();

    $formattedCheckIn = null;
    $formattedCheckOut = null;
    $hasStayDates = false;

    try {
        if ($checkInDate && $checkOutDate) {
            $formattedCheckIn = Carbon::parse($checkInDate)->format('d/m/Y');
            $formattedCheckOut = Carbon::parse($checkOutDate)->format('d/m/Y');
            $hasStayDates = true;
        }
    } catch (\Throwable $e) {
        $formattedCheckIn = null;
        $formattedCheckOut = null;
        $hasStayDates = false;
    }

    $capacity = (int) ($room->roomType?->capacity ?? 2);
    $price = (int) ($room->roomType?->price ?? 0);

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

    $availabilityLabel = $hasStayDates ? 'Phù hợp cho lịch đã chọn' : $statusText;
    $availabilityClasses = $hasStayDates ? 'bg-emerald-100 text-emerald-700' : $badgeClasses;

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

    $viewInfo = match(true) {
        str_contains($typeName, 'city') => 'Hướng thành phố',
        str_contains($typeName, 'suite') => 'View cao tầng thoáng rộng',
        $price >= 1500000 => 'Không gian sáng, thoáng và nhiều ánh sáng tự nhiên',
        default => 'View nội khu yên tĩnh',
    };

    $stayStyle = match(true) {
        $capacity >= 4 => 'Phù hợp cho gia đình hoặc nhóm nhỏ cần không gian rộng rãi.',
        $capacity === 3 => 'Phù hợp cho nhóm bạn nhỏ hoặc gia đình ít người.',
        default => 'Phù hợp cho khách công tác, cặp đôi hoặc lưu trú ngắn ngày.',
    };

    $amenities = [
        ['icon' => '🛏️', 'title' => 'Bố trí giường', 'desc' => $bedInfo],
        ['icon' => '📶', 'title' => 'WiFi tốc độ cao', 'desc' => 'Phù hợp cho làm việc, giải trí và họp trực tuyến'],
        ['icon' => '❄️', 'title' => 'Điều hòa riêng', 'desc' => 'Điều chỉnh nhiệt độ linh hoạt theo nhu cầu'],
        ['icon' => '🛁', 'title' => 'Phòng tắm riêng', 'desc' => 'Không gian riêng tư, sạch sẽ và tiện dụng'],
        ['icon' => '☕', 'title' => 'Nước uống & trà', 'desc' => 'Chuẩn bị sẵn để trải nghiệm lưu trú thoải mái hơn'],
        ['icon' => '📺', 'title' => 'TV màn hình phẳng', 'desc' => 'Giải trí nhẹ nhàng trong thời gian nghỉ ngơi'],
        ['icon' => '🧴', 'title' => 'Đồ dùng cơ bản', 'desc' => 'Khăn tắm, dầu gội, sữa tắm và vật dụng thiết yếu'],
        ['icon' => '🪟', 'title' => 'Không gian thoáng', 'desc' => $viewInfo],
    ];

    $highlights = [
        'Thiết kế gọn gàng, hiện đại và dễ tạo cảm giác thư giãn ngay khi nhận phòng.',
        'Thông tin giá, sức chứa và trạng thái hiển thị rõ ràng, thuận tiện để ra quyết định nhanh.',
        'Phù hợp cho cả khách công tác lẫn khách nghỉ ngắn ngày cần trải nghiệm lưu trú chỉn chu.',
        'Kết nối trực tiếp với luồng đặt phòng và tra cứu booking, giúp trải nghiệm liền mạch hơn.',
    ];

    $policies = [
        ['title' => 'Giờ nhận phòng', 'value' => 'Từ 14:00'],
        ['title' => 'Giờ trả phòng', 'value' => 'Trước 12:00'],
        ['title' => 'Sức chứa tiêu chuẩn', 'value' => 'Tối đa ' . $capacity . ' người theo cấu hình hiện tại của hệ thống.'],
        ['title' => 'Xác nhận booking', 'value' => 'Yêu cầu gửi từ website sẽ được tiếp nhận trước, sau đó nhân viên xác nhận theo tình trạng thực tế.'],
        ['title' => 'Thanh toán', 'value' => 'Tùy quy trình vận hành, booking có thể được ghi nhận thanh toán một phần hoặc toàn bộ.'],
        ['title' => 'Lưu ý khi lưu trú', 'value' => 'Vui lòng chuẩn bị giấy tờ cá nhân hợp lệ khi làm thủ tục nhận phòng.'],
    ];

    $faqs = [
        ['q' => 'Phòng này phù hợp cho bao nhiêu người?', 'a' => 'Phòng hiện được cấu hình phù hợp tối đa khoảng ' . $capacity . ' người theo dữ liệu của hệ thống.'],
        ['q' => 'Tôi có thể đặt phòng trực tiếp từ trang này không?', 'a' => 'Có. Anh có thể chọn ngày lưu trú ngay tại khung bên phải rồi chuyển sang form đặt phòng để gửi thông tin.'],
        ['q' => 'Nếu đã gửi booking thì xem lại ở đâu?', 'a' => 'Anh có thể vào mục tra cứu booking và nhập mã booking kèm email hoặc số điện thoại để xem lại trạng thái.'],
        ['q' => 'Trạng thái phòng ở đây có luôn chính xác theo ngày không?', 'a' => 'Nếu anh đi từ danh sách phòng có chọn ngày, hệ thống sẽ giữ lại thông tin ngày ở để hỗ trợ luồng đặt phòng chính xác hơn.'],
    ];

    $heroStats = [
        ['label' => 'Giá tham khảo', 'value' => number_format($price, 0, ',', '.') . ' đ / đêm'],
        ['label' => 'Sức chứa', 'value' => $capacity . ' người'],
        ['label' => 'Diện tích', 'value' => $area],
    ];
@endphp

<x-layouts.public
    title="Phòng {{ $room->room_number }} - {{ $room->roomType?->name }} | Navara Boutique Hotel"
    metaDescription="Khám phá chi tiết phòng {{ $room->room_number }} - {{ $room->roomType?->name }} tại Navara Boutique Hotel, xem giá, sức chứa, tiện ích và gửi yêu cầu đặt phòng nhanh chóng."
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

        .room-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .room-shell-card-strong {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(9, 26, 64, 0.14);
            box-shadow: 0 28px 70px rgba(5, 15, 40, 0.18);
            backdrop-filter: blur(8px);
        }

        .room-hover-card {
            position: relative;
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        }

        .room-hover-card:hover {
            transform: translateY(-8px);
            border-color: rgba(23, 63, 138, 0.16);
            box-shadow: var(--navara-shadow-lg);
        }

        .room-hover-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,.06) 45%, rgba(255,255,255,.22) 50%, transparent 55%);
            transform: translateX(-130%) skewX(-18deg);
            pointer-events: none;
            z-index: 2;
        }

        .room-hover-card:hover::after {
            animation: shineSweep .9s ease;
        }

        .room-hover-card img {
            transition: transform .8s ease;
        }

        .room-hover-card:hover img {
            transform: scale(1.06);
        }

        .room-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .room-chip {
            border: 1px solid rgba(23, 63, 138, 0.08);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(6px);
        }

        .room-hero {
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

        .room-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(46, 196, 182, 0.12), transparent 24%),
                linear-gradient(to top, rgba(8, 26, 69, 0.16), rgba(8, 26, 69, 0.02));
            pointer-events: none;
        }

        .room-hero-badge {
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
        }

        .room-hero-inner-card {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(8, 26, 69, 0.16);
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
            .room-floating-orb,
            .hero-copy-reveal,
            .hero-panel-reveal,
            .hero-stats-reveal,
            .reveal-on-scroll,
            .reveal-on-scroll.is-visible,
            .room-hover-card::after,
            .room-hover-card img,
            .nav-btn-hover,
            .room-hover-card {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>

    <section class="room-hero min-h-[700px] lg:min-h-[760px]">
        <div class="absolute -left-14 top-20 h-40 w-40 rounded-full bg-white/10 blur-3xl room-floating-orb"></div>
        <div class="absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl room-floating-orb"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="hero-copy-reveal">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <a
                            href="{{ route('public.rooms.index', array_filter([
                                'check_in_date' => $checkInDate,
                                'check_out_date' => $checkOutDate,
                            ])) }}"
                            class="transition hover:text-white"
                        >
                            Phòng nghỉ
                        </a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">Phòng {{ $room->room_number }}</span>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <span class="room-hero-badge rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">
                            {{ $room->roomType?->name ?? 'Hạng phòng' }}
                        </span>
                        <span class="rounded-full px-4 py-2 text-xs font-bold {{ $availabilityClasses }}">
                            {{ $availabilityLabel }}
                        </span>
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[3.9rem] lg:leading-[1.04]">
                        Phòng {{ $room->room_number }} mang lại trải nghiệm lưu trú gọn gàng, sang và dễ lựa chọn.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        {{ $room->roomType?->description ?: 'Không gian lưu trú được bố trí theo hướng chỉn chu, hiện đại và phù hợp cho cả khách công tác lẫn nghỉ dưỡng ngắn ngày.' }}
                    </p>

                    @if($hasStayDates)
                        <div class="mt-6 inline-flex rounded-full border border-emerald-300/20 bg-emerald-400/10 px-4 py-2 text-sm font-semibold text-emerald-100">
                            Lịch đang chọn: {{ $formattedCheckIn }} → {{ $formattedCheckOut }}
                        </div>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="{{ route('public.bookings.create', array_filter([
                                'room' => $room->id,
                                'check_in_date' => $checkInDate,
                                'check_out_date' => $checkOutDate,
                            ])) }}"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Đặt phòng ngay
                        </a>

                        <a
                            href="{{ route('public.rooms.index', array_filter([
                                'check_in_date' => $checkInDate,
                                'check_out_date' => $checkOutDate,
                            ])) }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Quay lại danh sách phòng
                        </a>
                    </div>
                </div>

                <div class="hero-panel-reveal room-shell-card-strong overflow-hidden rounded-[2rem] p-4 sm:p-5 lg:p-6">
                    <div class="room-hero-inner-card rounded-[1.75rem] p-6 text-slate-900 sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Thông tin nhanh</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">Tóm tắt trước khi gửi yêu cầu đặt phòng</h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Mã phòng</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">#{{ $room->id }} · {{ $room->room_number }}</p>
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
                            {{ $stayStyle }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-8">
                <div class="reveal-on-scroll reveal-delay-1 grid gap-4 lg:grid-cols-[1.22fr_0.78fr]">
                    <div class="room-shell-card overflow-hidden rounded-[2rem] bg-white">
                        <img
                            src="{{ $galleryImages[0] }}"
                            alt="Ảnh chính phòng {{ $room->room_number }}"
                            class="h-[420px] w-full object-cover"
                        >
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                        @foreach(array_slice($galleryImages, 1, 4) as $image)
                            <div class="room-shell-card overflow-hidden rounded-[2rem] bg-white">
                                <img
                                    src="{{ $image }}"
                                    alt="Hình ảnh thêm của phòng {{ $room->room_number }}"
                                    class="h-[198px] w-full object-cover"
                                    loading="lazy"
                                >
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-1 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="room-shell-card rounded-[2rem] bg-white p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Giá tham khảo</p>
                        <p class="mt-3 text-2xl font-black text-slate-900">{{ number_format($price, 0, ',', '.') }} đ</p>
                        <p class="mt-2 text-sm text-slate-500">Mỗi đêm lưu trú</p>
                    </div>

                    <div class="room-shell-card rounded-[2rem] bg-white p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Sức chứa</p>
                        <p class="mt-3 text-2xl font-black text-slate-900">{{ $capacity }} người</p>
                        <p class="mt-2 text-sm text-slate-500">Phù hợp theo cấu hình hiện tại</p>
                    </div>

                    <div class="room-shell-card rounded-[2rem] bg-white p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Diện tích ước tính</p>
                        <p class="mt-3 text-2xl font-black text-slate-900">{{ $area }}</p>
                        <p class="mt-2 text-sm text-slate-500">Bố cục rộng rãi, dễ sử dụng</p>
                    </div>

                    <div class="room-shell-card rounded-[2rem] bg-white p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Tầng / view</p>
                        <p class="mt-3 text-lg font-black text-slate-900">{{ $room->floor ?? 'Đang cập nhật' }}</p>
                        <p class="mt-2 text-sm text-slate-500">{{ $viewInfo }}</p>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 room-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tổng quan phòng</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Không gian lưu trú được thiết kế để tạo cảm giác thoải mái ngay từ lần xem đầu tiên.
                    </h2>

                    <div class="mt-6 space-y-5 text-base leading-8 text-slate-600">
                        <p>
                            {{ $room->roomType?->description ?: 'Hạng phòng này được bố trí theo hướng hiện đại, chỉn chu và phù hợp cho nhu cầu lưu trú ngắn ngày lẫn dài ngày.' }}
                        </p>
                        <p>
                            Phòng {{ $room->room_number }} là lựa chọn phù hợp cho những ai cần một không gian lưu trú rõ ràng về thông tin, thuận tiện trong thao tác đặt phòng và dễ kiểm tra lại trạng thái sau khi gửi booking.
                        </p>
                        <p>
                            Từ mức giá, sức chứa, trạng thái hiện tại cho tới liên kết đặt phòng, mọi thành phần đều được trình bày theo hướng trực quan để trải nghiệm người dùng liền mạch và chuyên nghiệp hơn.
                        </p>
                    </div>

                    <div class="mt-8 grid gap-4 md:grid-cols-2">
                        @foreach($highlights as $item)
                            <div class="flex gap-3 rounded-[1.6rem] bg-slate-50 p-4">
                                <div class="mt-1 text-[#173F8A]">✓</div>
                                <p class="text-sm leading-7 text-slate-700">{{ $item }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 room-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tiện ích trong phòng</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Những tiện nghi giúp trải nghiệm lưu trú đầy đủ và thoải mái hơn.
                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        @foreach($amenities as $amenity)
                            <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                                <div class="text-3xl">{{ $amenity['icon'] }}</div>
                                <h3 class="mt-4 text-lg font-extrabold text-slate-900">{{ $amenity['title'] }}</h3>
                                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $amenity['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-3 room-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Chính sách lưu trú</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Thông tin nên xem trước khi gửi yêu cầu đặt phòng.
                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-2">
                        @foreach($policies as $policy)
                            <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-slate-500">{{ $policy['title'] }}</p>
                                <p class="mt-3 text-sm leading-7 text-slate-700">{{ $policy['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-3 room-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Câu hỏi thường gặp</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Giải đáp nhanh trước khi anh đặt phòng.
                    </h2>

                    <div class="mt-8 space-y-4">
                        @foreach($faqs as $faq)
                            <details class="group rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                                <summary class="cursor-pointer list-none text-lg font-extrabold text-slate-900">
                                    {{ $faq['q'] }}
                                </summary>
                                <p class="mt-4 text-sm leading-7 text-slate-600">
                                    {{ $faq['a'] }}
                                </p>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
                <div class="reveal-on-scroll reveal-delay-1 room-shell-card rounded-[2rem] bg-white p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-[#173F8A]">{{ $room->roomType?->name }}</p>
                            <h2 class="mt-2 text-2xl font-black text-slate-900">Đặt phòng {{ $room->room_number }}</h2>
                        </div>

                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $availabilityClasses }}">
                            {{ $availabilityLabel }}
                        </span>
                    </div>

                    <div class="mt-6 rounded-[1.6rem] bg-slate-50 p-5">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Giá tham khảo / đêm</span>
                            <strong class="text-lg text-slate-900">{{ number_format($price, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Sức chứa tối đa</span>
                            <strong class="text-slate-900">{{ $capacity }} người</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Diện tích</span>
                            <strong class="text-slate-900">{{ $area }}</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Loại giường</span>
                            <strong class="text-slate-900">{{ $bedInfo }}</strong>
                        </div>
                    </div>

                    @if($hasStayDates)
                        <div class="mt-5 rounded-[1.4rem] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                            Lịch đang chọn: {{ $formattedCheckIn }} → {{ $formattedCheckOut }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('public.bookings.create', ['room' => $room->id]) }}" class="mt-6 space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày nhận phòng</label>
                            <input
                                type="date"
                                name="check_in_date"
                                min="{{ $today }}"
                                value="{{ $checkInDate }}"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-[#173F8A] focus:outline-none focus:ring-4 focus:ring-[#173F8A]/10"
                            >
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày trả phòng</label>
                            <input
                                type="date"
                                name="check_out_date"
                                min="{{ $checkInDate ?: $today }}"
                                value="{{ $checkOutDate }}"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 transition focus:border-[#173F8A] focus:outline-none focus:ring-4 focus:ring-[#173F8A]/10"
                            >
                        </div>

                        <button
                            type="submit"
                            class="nav-btn-hover w-full rounded-full bg-[#173F8A] px-5 py-3 text-sm font-semibold text-white hover:bg-[#143374] hover:shadow-[0_14px_32px_rgba(23,63,138,0.18)]"
                        >
                            Kiểm tra và đặt phòng
                        </button>
                    </form>

                    <div class="mt-5 rounded-[1.6rem] border border-[#173F8A]/10 bg-[linear-gradient(135deg,rgba(23,63,138,0.05),rgba(46,196,182,0.08))] p-4 text-sm leading-7 text-slate-700">
                        Yêu cầu đặt phòng gửi từ website sẽ được tiếp nhận trước, sau đó nhân viên xác nhận lại theo trạng thái thực tế và lịch lưu trú đã chọn.
                    </div>

                    <div class="mt-5 flex flex-col gap-3">
                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                        >
                            Tra cứu booking
                        </a>

                        <a
                            href="{{ route('public.rooms.index', array_filter([
                                'check_in_date' => $checkInDate,
                                'check_out_date' => $checkOutDate,
                            ])) }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                        >
                            Xem thêm phòng khác
                        </a>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 room-shell-card rounded-[2rem] bg-white p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Phù hợp với ai?</p>
                    <h3 class="mt-3 text-2xl font-black text-slate-900">Gợi ý nhanh theo nhu cầu lưu trú</h3>
                    <div class="mt-5 space-y-3 text-sm leading-7 text-slate-600">
                        <p>• Khách công tác cần phòng gọn gàng, rõ thông tin và dễ đặt nhanh.</p>
                        <p>• Cặp đôi hoặc nhóm nhỏ muốn không gian lưu trú riêng tư, thoải mái.</p>
                        <p>• Gia đình nhỏ cần lựa chọn minh bạch về giá, sức chứa và lịch ở.</p>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-3 room-shell-card overflow-hidden rounded-[2rem] bg-[#081A45] p-6 text-white">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#9ff4ec]">Hỗ trợ nhanh</p>
                    <h3 class="mt-3 text-2xl font-black">Cần so sánh thêm giữa các hạng phòng?</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Anh có thể quay lại danh sách phòng để lọc theo ngày, sức chứa hoặc loại phòng rồi so sánh trực quan trước khi gửi yêu cầu.
                    </p>
                    <a
                        href="{{ route('public.rooms.index', array_filter([
                            'check_in_date' => $checkInDate,
                            'check_out_date' => $checkOutDate,
                        ])) }}"
                        class="nav-btn-hover mt-6 inline-flex rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#081A45] hover:bg-slate-100"
                    >
                        Khám phá thêm phòng
                    </a>
                </div>
            </aside>
        </div>
    </section>

    <section class="bg-slate-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="reveal-on-scroll mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Phòng liên quan</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Một số lựa chọn cùng hạng để anh cân nhắc thêm.
                    </h2>
                </div>

                <a
                    href="{{ route('public.rooms.index', ['room_type_id' => $room->room_type_id]) }}"
                    class="nav-btn-hover inline-flex rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-white hover:text-[#173F8A]"
                >
                    Xem các phòng cùng loại
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($relatedRooms as $relatedRoom)
                    @php
                        $relatedImage = $galleryImages[$loop->index % count($galleryImages)];

                        $relatedBadgeClasses = match($relatedRoom->status) {
                            'available' => 'bg-emerald-100 text-emerald-700',
                            'booked' => 'bg-amber-100 text-amber-700',
                            'occupied' => 'bg-rose-100 text-rose-700',
                            default => 'bg-slate-100 text-slate-700',
                        };

                        $relatedStatusText = match($relatedRoom->status) {
                            'available' => 'Còn trống',
                            'booked' => 'Đã được đặt',
                            'occupied' => 'Đang sử dụng',
                            default => ucfirst((string) $relatedRoom->status),
                        };
                    @endphp

                    <article class="room-hover-card reveal-on-scroll overflow-hidden rounded-[2rem] bg-white" style="animation-delay: {{ 0.04 * $loop->index }}s;">
                        <div class="relative h-60 overflow-hidden">
                            <img
                                src="{{ $relatedImage }}"
                                alt="Hình ảnh phòng {{ $relatedRoom->room_number }}"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#081A45]/70 via-[#081A45]/10 to-transparent"></div>

                            <div class="absolute left-4 top-4 z-[3] flex flex-wrap gap-2">
                                <span class="room-type-badge rounded-full px-3.5 py-1.5 text-xs font-extrabold tracking-[0.02em]">
                                    {{ $relatedRoom->roomType?->name ?? 'Phòng nghỉ' }}
                                </span>
                                <span class="room-status-badge rounded-full px-3 py-1.5 text-xs font-bold {{ $relatedBadgeClasses }}">
                                    {{ $relatedStatusText }}
                                </span>
                            </div>

                            <div class="absolute inset-x-4 bottom-4 z-[3] text-white">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/70">Phòng {{ $relatedRoom->room_number }}</p>
                                <p class="mt-2 text-2xl font-black">
                                    {{ number_format($relatedRoom->roomType?->price ?? 0, 0, ',', '.') }} đ
                                    <span class="text-base font-semibold text-white/80">/ đêm</span>
                                </p>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4 rounded-[1.6rem] bg-slate-50 p-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Sức chứa</p>
                                    <p class="mt-2 text-lg font-black text-slate-900">{{ $relatedRoom->roomType?->capacity ?? 0 }} người</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Tầng</p>
                                    <p class="mt-2 text-lg font-black text-slate-900">{{ $relatedRoom->floor ?? 'Đang cập nhật' }}</p>
                                </div>
                            </div>

                            <p class="mt-5 text-sm leading-7 text-slate-600">
                                {{ \Illuminate\Support\Str::limit($relatedRoom->roomType?->description ?: 'Không gian lưu trú hiện đại, rõ ràng về thông tin và phù hợp cho nhiều nhu cầu lưu trú.', 120) }}
                            </p>

                            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <a
                                    href="{{ route('public.rooms.show', array_filter([
                                        'room' => $relatedRoom->id,
                                        'check_in_date' => $checkInDate,
                                        'check_out_date' => $checkOutDate,
                                    ])) }}"
                                    class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                                >
                                    Xem chi tiết
                                </a>

                                <a
                                    href="{{ route('public.bookings.create', array_filter([
                                        'room' => $relatedRoom->id,
                                        'check_in_date' => $checkInDate,
                                        'check_out_date' => $checkOutDate,
                                    ])) }}"
                                    class="nav-btn-hover inline-flex items-center justify-center rounded-full bg-[#173F8A] px-4 py-3 text-sm font-semibold text-white hover:bg-[#143374] hover:shadow-[0_14px_32px_rgba(23,63,138,0.18)]"
                                >
                                    Đặt ngay
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="room-shell-card rounded-[2rem] border-dashed bg-white p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                        Hiện chưa có thêm phòng cùng loại để hiển thị.
                    </div>
                @endforelse
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