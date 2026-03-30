@php
    $today = now()->toDateString();
    $tomorrow = now()->addDay()->toDateString();

    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroImage = $assetOrFallback(
        'images/user/hero-hotel.jpg',
        'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=2200&q=90'
    );

    $roomTypeImages = [
        $assetOrFallback('images/user/room-type-1.jpg', 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-2.jpg', 'https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-3.jpg', 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-4.jpg', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-5.jpg', 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-6.jpg', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80'),
    ];

    $featuredRoomImages = [
        $assetOrFallback('images/user/featured-room-1.jpg', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-2.jpg', 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-3.jpg', 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-4.jpg', 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-5.jpg', 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-6.jpg', 'https://images.unsplash.com/photo-1455587734955-081b22074882?auto=format&fit=crop&w=1200&q=80'),
    ];

    $highlights = [
        [
            'title' => 'Vị trí thuận tiện',
            'desc' => 'Tọa lạc tại khu vực trung tâm, thuận tiện di chuyển cho cả lịch trình công tác và nghỉ dưỡng.',
        ],
        [
            'title' => 'Không gian tinh tế',
            'desc' => 'Thiết kế hiện đại, sạch sẽ và ấm cúng, phù hợp với nhiều nhóm khách lưu trú khác nhau.',
        ],
        [
            'title' => 'Quy trình rõ ràng',
            'desc' => 'Xem phòng, gửi booking và tra cứu thông tin nhanh chóng trong một trải nghiệm trực quan hơn.',
        ],
    ];

    $services = [
        [
            'title' => 'Lễ tân 24/7',
            'desc' => 'Đội ngũ hỗ trợ linh hoạt cho nhu cầu nhận phòng, trả phòng và các yêu cầu phát sinh.',
        ],
        [
            'title' => 'WiFi tốc độ cao',
            'desc' => 'Phù hợp cho làm việc từ xa, giải trí và các nhu cầu kết nối liên tục trong thời gian lưu trú.',
        ],
        [
            'title' => 'Bữa sáng tiện lợi',
            'desc' => 'Thực đơn gọn gàng, phù hợp cho khách công tác hoặc khách hàng cần lịch trình linh hoạt.',
        ],
        [
            'title' => 'Không gian chỉn chu',
            'desc' => 'Ưu tiên sự ngăn nắp, dễ chịu và cảm giác chuyên nghiệp xuyên suốt trải nghiệm lưu trú.',
        ],
    ];

    $whyChooseUs = [
        [
            'number' => '01',
            'title' => 'Thông tin rõ ràng',
            'desc' => 'Giá phòng, sức chứa, thời gian lưu trú và trạng thái booking được thể hiện trực quan và dễ theo dõi.',
        ],
        [
            'number' => '02',
            'title' => 'Đặt phòng thuận tiện',
            'desc' => 'Khách hàng có thể kiểm tra phòng trống theo ngày và gửi yêu cầu đặt phòng chỉ trong vài bước ngắn gọn.',
        ],
        [
            'number' => '03',
            'title' => 'Tra cứu dễ dàng',
            'desc' => 'Xem lại booking bằng mã đặt phòng cùng email hoặc số điện thoại đã sử dụng khi đặt.',
        ],
    ];

    $testimonials = [
        [
            'name' => 'Nguyễn Minh Anh',
            'type' => 'Gia đình',
            'content' => 'Không gian website rất chỉn chu, dễ xem phòng và tra cứu booking nhanh. Trải nghiệm tổng thể tạo cảm giác tin cậy ngay từ lần đầu sử dụng.',
        ],
        [
            'name' => 'Trần Quốc Huy',
            'type' => 'Công tác',
            'content' => 'Tôi thích cách trình bày thông tin rõ ràng, màu sắc sang và dễ thao tác. Phần đặt phòng và kiểm tra phòng trống được làm rất gọn.',
        ],
        [
            'name' => 'Lê Hoàng Lan',
            'type' => 'Cặp đôi',
            'content' => 'Ảnh đẹp, bố cục thoáng và cảm giác thương hiệu rất đồng nhất. Đây là kiểu giao diện khiến người dùng muốn tìm hiểu thêm ngay.',
        ],
    ];

    $faqs = [
        [
            'q' => 'Tôi có thể kiểm tra phòng trống theo ngày không?',
            'a' => 'Có. Bạn có thể nhập ngày nhận và trả phòng tại khu vực kiểm tra phòng trống ngay trên trang chủ.',
        ],
        [
            'q' => 'Sau khi gửi booking thì trạng thái là gì?',
            'a' => 'Booking từ website sẽ được ghi nhận ở trạng thái chờ xác nhận để bộ phận lễ tân kiểm tra và liên hệ lại.',
        ],
        [
            'q' => 'Làm sao để xem lại booking của tôi?',
            'a' => 'Bạn chỉ cần dùng mã booking cùng email hoặc số điện thoại đã sử dụng khi đặt phòng.',
        ],
        [
            'q' => 'Có xem được thông tin thanh toán không?',
            'a' => 'Có. Khu vực tra cứu booking sẽ hiển thị tổng tiền, đã thanh toán, còn lại và lịch sử thanh toán nếu đã phát sinh.',
        ],
    ];

    $newsItems = [
        [
            'slug' => 'kinh-nghiem-chon-hang-phong-phu-hop-cho-chuyen-di-ngan-ngay',
            'category' => 'Kinh nghiệm đặt phòng',
            'title' => 'Kinh nghiệm chọn hạng phòng phù hợp cho chuyến đi ngắn ngày',
            'desc' => 'Một vài gợi ý giúp bạn chọn Standard, Deluxe hay Family Room theo đúng nhu cầu và ngân sách.',
            'image' => $assetOrFallback('images/user/news-1.jpg', 'https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1400&q=80'),
        ],
        [
            'slug' => 'nen-dat-phong-khach-san-truoc-bao-lau-de-co-lua-chon-tot',
            'category' => 'Cẩm nang du lịch',
            'title' => 'Nên đặt phòng khách sạn trước bao lâu để có lựa chọn tốt?',
            'desc' => 'Chủ động đặt sớm giúp bạn dễ chọn hạng phòng phù hợp và tối ưu kế hoạch di chuyển hơn.',
            'image' => $assetOrFallback('images/user/news-2.jpg', 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1400&q=80'),
        ],
        [
            'slug' => 'checklist-luu-tru-cho-gia-dinh-co-tre-nho',
            'category' => 'Gia đình & nghỉ dưỡng',
            'title' => 'Checklist lưu trú cho gia đình có trẻ nhỏ',
            'desc' => 'Những lưu ý đơn giản về sức chứa, tiện ích và cách chọn phòng khi đi cùng trẻ em.',
            'image' => $assetOrFallback('images/user/news-3.jpg', 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1400&q=80'),
        ],
    ];
@endphp

<x-layouts.public
    title="Navara Boutique Hotel - Không gian lưu trú hiện đại và tinh tế"
    metaDescription="Khám phá các hạng phòng tiện nghi, kiểm tra phòng trống theo ngày và gửi yêu cầu đặt phòng nhanh chóng tại Navara Boutique Hotel."
>
    <style>
        html {
            scroll-behavior: smooth;
        }

        :root {
            --navara-navy: #173F8A;
            --navara-navy-deep: #081A45;
            --navara-teal: #2EC4B6;
            --navara-teal-dark: #27B0A3;
            --navara-border: rgba(15, 23, 42, 0.08);
            --navara-shadow-soft: 0 10px 30px rgba(15, 23, 42, 0.06);
            --navara-shadow-lg: 0 24px 64px rgba(8, 26, 69, 0.12);
        }

        @keyframes heroZoom {
            from { transform: scale(1.045); }
            to { transform: scale(1); }
        }

        @keyframes floatSoft {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: .45; transform: scale(1); }
            50% { opacity: .8; transform: scale(1.08); }
        }

        .hero-image-animate {
            animation: heroZoom 1.6s ease-out both;
        }

        .hero-float {
            animation: floatSoft 6s ease-in-out infinite;
        }

        .hero-pulse {
            animation: pulseGlow 5s ease-in-out infinite;
        }

        .premium-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        }

        .premium-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--navara-shadow-lg);
            border-color: rgba(23, 63, 138, 0.16);
        }

        .glass-panel {
            background: linear-gradient(180deg, rgba(255,255,255,0.16), rgba(255,255,255,0.08));
            border: 1px solid rgba(255,255,255,0.14);
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        }

        .section-kicker {
            letter-spacing: .22em;
        }

        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .7s ease, transform .7s ease;
            will-change: opacity, transform;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger-1 { transition-delay: .06s; }
        .stagger-2 { transition-delay: .12s; }
        .stagger-3 { transition-delay: .18s; }
        .stagger-4 { transition-delay: .24s; }
        .stagger-5 { transition-delay: .3s; }
        .stagger-6 { transition-delay: .36s; }

        .soft-ring {
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.08),
                0 20px 40px rgba(8, 26, 69, 0.18);
        }

        .lux-divider {
            background: linear-gradient(90deg, rgba(23,63,138,0), rgba(23,63,138,.22), rgba(46,196,182,.28), rgba(23,63,138,0));
        }

        .faq-item[open] {
            border-color: rgba(23, 63, 138, 0.16);
            box-shadow: 0 16px 36px rgba(8, 26, 69, 0.08);
        }

        .faq-item summary::-webkit-details-marker {
            display: none;
        }

        .img-hover img {
            transition: transform .7s ease;
        }

        .img-hover:hover img {
            transform: scale(1.06);
        }

        .hero-copy {
            text-wrap: balance;
        }

        @media (prefers-reduced-motion: reduce) {
            .hero-image-animate,
            .hero-float,
            .hero-pulse,
            .premium-card,
            .reveal,
            .img-hover img {
                animation: none !important;
                transition: none !important;
                transform: none !important;
            }
        }
    </style>

    <section class="relative min-h-[86vh] overflow-hidden bg-slate-950">
        <div class="absolute inset-0">
            <img
                src="{{ $heroImage }}"
                alt="Không gian khách sạn hiện đại"
                class="hero-image-animate h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-[#081A45]/92 via-[#173F8A]/62 to-[#173F8A]/16"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_12%_22%,rgba(46,196,182,0.18),transparent_24%),radial-gradient(circle_at_82%_18%,rgba(255,255,255,0.08),transparent_18%),radial-gradient(circle_at_72%_80%,rgba(46,196,182,0.12),transparent_22%)]"></div>
            <div class="absolute inset-0 bg-black/8"></div>
        </div>

        <div class="hero-pulse absolute left-[6%] top-[24%] hidden h-32 w-32 rounded-full bg-[#2EC4B6]/10 blur-3xl lg:block"></div>
        <div class="hero-float absolute right-[10%] top-[18%] hidden h-28 w-28 rounded-full bg-white/10 blur-3xl lg:block"></div>

        <div class="relative mx-auto flex min-h-[86vh] max-w-7xl items-center px-4 pt-16 pb-24 sm:px-6 sm:pt-20 sm:pb-28 lg:px-8 lg:pt-20 lg:pb-32">
            <div class="grid w-full gap-10 lg:grid-cols-[1.08fr_0.92fr] lg:items-end">
                <div class="reveal is-visible max-w-3xl rounded-[2.25rem] border border-white/10 bg-white/8 p-7 backdrop-blur-[5px] sm:p-10 soft-ring">
                    <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-4 py-1.5 text-sm font-medium text-white/95">
                        Boutique hotel · Trung tâm thành phố · Hỗ trợ 24/7
                    </span>

                    <h1 class="hero-copy mt-6 max-w-3xl text-[2.8rem] font-extrabold leading-[0.98] text-white sm:text-[4rem] lg:text-[5.2rem]">
                        Không gian lưu trú
                        <span class="block text-white/96">tinh tế và chuyên nghiệp</span>
                        <span class="mt-2 block text-[#2EC4B6]">cho mọi hành trình lưu trú</span>
                    </h1>

                    <div class="lux-divider mt-7 h-px w-full"></div>

                    <p class="mt-7 max-w-2xl text-base leading-8 text-slate-100 sm:text-lg">
                        Tận hưởng trải nghiệm lưu trú hiện đại với hệ thống phòng chỉn chu, thông tin rõ ràng và quy trình đặt phòng trực quan cho cả khách công tác lẫn nghỉ dưỡng.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="inline-flex items-center rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-slate-950 transition duration-300 hover:-translate-y-0.5 hover:bg-[#27b0a3] hover:shadow-[0_16px_32px_rgba(46,196,182,0.24)]"
                        >
                            Xem danh sách phòng
                        </a>

                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-6 py-3 text-sm font-semibold text-white transition duration-300 hover:-translate-y-0.5 hover:bg-white/16"
                        >
                            Tra cứu booking
                        </a>
                    </div>

                    <div class="mt-10 grid gap-4 sm:grid-cols-3">
                        <div class="glass-panel rounded-2xl p-4">
                            <p class="text-xs uppercase tracking-[0.22em] text-white/65">Vị trí</p>
                            <p class="mt-2 text-sm font-semibold text-white">Trung tâm, dễ di chuyển</p>
                        </div>
                        <div class="glass-panel rounded-2xl p-4">
                            <p class="text-xs uppercase tracking-[0.22em] text-white/65">Dịch vụ</p>
                            <p class="mt-2 text-sm font-semibold text-white">Lễ tân hỗ trợ 24/7</p>
                        </div>
                        <div class="glass-panel rounded-2xl p-4">
                            <p class="text-xs uppercase tracking-[0.22em] text-white/65">Trải nghiệm</p>
                            <p class="mt-2 text-sm font-semibold text-white">Đặt phòng rõ ràng, dễ tra cứu</p>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:block">
                    <div class="reveal stagger-2 ml-auto max-w-md rounded-[2rem] border border-white/10 bg-white/10 p-6 text-white backdrop-blur-md soft-ring">
                        <p class="section-kicker text-sm font-semibold uppercase text-[#8FF3EA]">Navara Signature</p>
                        <h3 class="mt-3 text-2xl font-bold tracking-tight">Lưu trú sang trọng theo phong cách hiện đại</h3>
                        <p class="mt-4 text-sm leading-7 text-slate-100/90">
                            Không gian được định hình theo tinh thần tinh tế, mạch lạc và thư giãn để mỗi điểm chạm trên website đều tạo cảm giác cao cấp và tin cậy hơn.
                        </p>

                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-xs uppercase tracking-[0.18em] text-white/60">Phòng khả dụng</p>
                                <p class="mt-2 text-3xl font-bold text-white">{{ $stats['available_rooms'] }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-4">
                                <p class="text-xs uppercase tracking-[0.18em] text-white/60">Hạng phòng</p>
                                <p class="mt-2 text-3xl font-bold text-white">{{ $stats['room_types'] }}</p>
                            </div>
                        </div>

                        <div class="mt-5 rounded-2xl border border-white/10 bg-black/10 p-4">
                            <p class="text-xs uppercase tracking-[0.18em] text-white/60">Điểm nhấn</p>
                            <p class="mt-2 text-sm font-medium text-white/95">Bố cục thoáng, hiệu ứng nhẹ, màu sắc nhất quán và trải nghiệm dễ sử dụng trên mọi thiết bị.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-10 -mt-16 sm:-mt-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="reveal rounded-[2rem] border border-slate-200/80 bg-white/95 p-6 shadow-[0_30px_80px_rgba(8,26,69,0.14)] backdrop-blur sm:p-8">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-2xl">
                        <p class="section-kicker text-sm font-semibold uppercase text-[#173F8A]">Kiểm tra phòng trống</p>
                        <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                            Chọn thời gian lưu trú để xem các phòng phù hợp
                        </h2>
                        <p class="mt-3 text-sm leading-7 text-slate-600">
                            Khu vực tìm phòng được đặt riêng để giúp bố cục thông thoáng hơn, dễ thao tác hơn và tập trung hơn vào trải nghiệm đặt phòng thực tế.
                        </p>
                    </div>

                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="inline-flex rounded-full border border-[#173F8A]/15 px-5 py-3 text-sm font-semibold text-[#173F8A] transition duration-300 hover:-translate-y-0.5 hover:bg-[#173F8A]/5"
                    >
                        Xem tất cả phòng
                    </a>
                </div>

                <form action="{{ route('public.rooms.index') }}" method="GET" class="mt-8 grid gap-4 lg:grid-cols-[1fr_1fr_0.9fr_1fr_auto]">
                    <div class="reveal stagger-1">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày nhận phòng</label>
                        <input
                            type="date"
                            name="check_in_date"
                            min="{{ $today }}"
                            value="{{ $today }}"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-300 focus:border-[#173F8A] focus:ring-4 focus:ring-[#173F8A]/10"
                        >
                    </div>

                    <div class="reveal stagger-2">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày trả phòng</label>
                        <input
                            type="date"
                            name="check_out_date"
                            min="{{ $tomorrow }}"
                            value="{{ $tomorrow }}"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-300 focus:border-[#173F8A] focus:ring-4 focus:ring-[#173F8A]/10"
                        >
                    </div>

                    <div class="reveal stagger-3">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Sức chứa</label>
                        <select
                            name="capacity"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-300 focus:border-[#173F8A] focus:ring-4 focus:ring-[#173F8A]/10"
                        >
                            <option value="">Tất cả</option>
                            <option value="1">1 khách</option>
                            <option value="2">2 khách</option>
                            <option value="3">3 khách</option>
                            <option value="4">4 khách trở lên</option>
                        </select>
                    </div>

                    <div class="reveal stagger-4">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Loại phòng</label>
                        <select
                            name="room_type_id"
                            class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition duration-300 focus:border-[#173F8A] focus:ring-4 focus:ring-[#173F8A]/10"
                        >
                            <option value="">Tất cả hạng phòng</option>
                            @foreach($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="reveal stagger-5 flex items-end">
                        <button
                            type="submit"
                            class="w-full rounded-full bg-[#173F8A] px-6 py-3.5 text-sm font-semibold text-white transition duration-300 hover:-translate-y-0.5 hover:bg-[#143374] hover:shadow-[0_16px_30px_rgba(23,63,138,0.22)] lg:w-auto"
                        >
                            Tìm phòng trống
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 py-10 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
            <div class="reveal premium-card rounded-[1.75rem] bg-white p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Hạng phòng</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-[#173F8A]">{{ $stats['room_types'] }}</p>
                <div class="mt-5 h-1.5 w-16 rounded-full bg-[#173F8A]/12">
                    <div class="h-1.5 w-10 rounded-full bg-[#173F8A]"></div>
                </div>
            </div>

            <div class="reveal stagger-1 premium-card rounded-[1.75rem] bg-white p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Tổng phòng</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-[#173F8A]">{{ $stats['rooms'] }}</p>
                <div class="mt-5 h-1.5 w-16 rounded-full bg-[#173F8A]/12">
                    <div class="h-1.5 w-12 rounded-full bg-[#2EC4B6]"></div>
                </div>
            </div>

            <div class="reveal stagger-2 premium-card rounded-[1.75rem] bg-white p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Phòng khả dụng</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-[#173F8A]">{{ $stats['available_rooms'] }}</p>
                <div class="mt-5 h-1.5 w-16 rounded-full bg-[#173F8A]/12">
                    <div class="h-1.5 w-11 rounded-full bg-[#173F8A]"></div>
                </div>
            </div>

            <div class="reveal stagger-3 premium-card rounded-[1.75rem] bg-white p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Booking đã ghi nhận</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-[#173F8A]">{{ $stats['bookings'] }}</p>
                <div class="mt-5 h-1.5 w-16 rounded-full bg-[#173F8A]/12">
                    <div class="h-1.5 w-9 rounded-full bg-[#2EC4B6]"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
        <div class="mb-12 max-w-3xl reveal">
            <p class="section-kicker text-sm font-semibold uppercase text-[#173F8A]">Giá trị nổi bật</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                Những yếu tố tạo nên cảm giác chỉn chu và sang trọng
            </h2>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            @foreach($highlights as $item)
                <article class="reveal {{ $loop->iteration > 1 ? 'stagger-'.$loop->iteration : '' }} premium-card rounded-[2rem] bg-white p-7">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#173F8A] text-sm font-bold text-white">
                        0{{ $loop->iteration }}
                    </div>
                    <h2 class="mt-5 text-2xl font-bold tracking-tight text-slate-950">{{ $item['title'] }}</h2>
                    <p class="mt-3 text-sm leading-7 text-slate-600">{{ $item['desc'] }}</p>
                    <div class="mt-6 h-px w-full bg-gradient-to-r from-[#173F8A]/20 via-[#2EC4B6]/30 to-transparent"></div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="bg-slate-100 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl reveal">
                    <p class="section-kicker text-sm font-semibold uppercase text-[#173F8A]">Loại phòng nổi bật</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                        Các hạng phòng được thiết kế cho nhiều nhu cầu lưu trú
                    </h2>
                    <p class="mt-4 text-base leading-8 text-slate-600">
                        Từ lựa chọn tối giản cho chuyến đi ngắn ngày đến các hạng phòng rộng rãi hơn cho gia đình, mọi thông tin đều được thể hiện rõ ràng và chuyên nghiệp.
                    </p>
                </div>

                <a
                    href="{{ route('public.rooms.index') }}"
                    class="reveal inline-flex rounded-full border border-[#173F8A]/15 px-5 py-3 text-sm font-semibold text-[#173F8A] transition duration-300 hover:-translate-y-0.5 hover:bg-white"
                >
                    Xem tất cả phòng
                </a>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($roomTypes as $roomType)
                    @php
                        $roomTypeImage = $roomTypeImages[$loop->index % count($roomTypeImages)];
                    @endphp

                    <article class="reveal {{ 'stagger-'.(($loop->index % 3) + 1) }} premium-card overflow-hidden rounded-[2rem] bg-white">
                        <div class="img-hover relative h-64 overflow-hidden">
                            <img
                                src="{{ $roomTypeImage }}"
                                alt="Hình ảnh loại phòng {{ $roomType->name }}"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#081A45]/48 via-[#173F8A]/18 to-transparent"></div>

                            <div class="absolute left-5 top-5">
                                <span class="rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-[#173F8A] shadow-sm">
                                    {{ $roomType->rooms_count }} phòng
                                </span>
                            </div>

                            <div class="absolute bottom-5 left-5">
                                <span class="rounded-full bg-black/25 px-3 py-1 text-xs font-medium text-white backdrop-blur">
                                    Hạng phòng phổ biến
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h3 class="text-2xl font-bold tracking-tight text-slate-950">{{ $roomType->name }}</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">
                                {{ $roomType->description ?: 'Không gian lưu trú hiện đại, phù hợp cho nghỉ dưỡng, công tác và các chuyến đi ngắn ngày.' }}
                            </p>

                            <div class="mt-6 grid grid-cols-2 gap-4 rounded-3xl bg-slate-50 p-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-slate-500">Giá từ</p>
                                    <p class="mt-2 text-lg font-bold text-[#173F8A]">
                                        {{ number_format($roomType->price, 0, ',', '.') }} đ
                                    </p>
                                    <p class="text-xs text-slate-500">/ đêm</p>
                                </div>

                                <div>
                                    <p class="text-xs uppercase tracking-wide text-slate-500">Sức chứa</p>
                                    <p class="mt-2 text-lg font-bold text-[#173F8A]">
                                        {{ $roomType->capacity }} người
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <a
                                    href="{{ route('public.rooms.index', ['room_type_id' => $roomType->id]) }}"
                                    class="rounded-full border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition duration-300 hover:-translate-y-0.5 hover:bg-slate-50"
                                >
                                    Xem phòng
                                </a>

                                <a
                                    href="{{ route('public.rooms.index', ['room_type_id' => $roomType->id, 'check_in_date' => $today, 'check_out_date' => $tomorrow]) }}"
                                    class="rounded-full bg-[#173F8A] px-4 py-2.5 text-sm font-semibold text-white transition duration-300 hover:-translate-y-0.5 hover:bg-[#143374]"
                                >
                                    Kiểm tra phòng trống
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                        Chưa có loại phòng để hiển thị.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr] lg:items-start">
            <div class="reveal">
                <p class="section-kicker text-sm font-semibold uppercase text-[#173F8A]">Vì sao chọn Navara</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                    Trải nghiệm lưu trú được chăm chút ở từng chi tiết
                </h2>
                <p class="mt-4 text-base leading-8 text-slate-600">
                    Từ hình ảnh, màu sắc đến luồng đặt phòng và tra cứu thông tin, mọi thành phần đều được tối ưu để mang lại cảm giác rõ ràng, tin cậy và dễ chịu hơn khi sử dụng.
                </p>

                <div class="mt-8 space-y-4">
                    @foreach($whyChooseUs as $item)
                        <div class="reveal {{ 'stagger-'.(($loop->index % 3) + 1) }} premium-card rounded-3xl bg-white p-5">
                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#173F8A] text-sm font-bold text-white">
                                    {{ $item['number'] }}
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-950">{{ $item['title'] }}</h3>
                                    <p class="mt-2 text-sm leading-7 text-slate-600">{{ $item['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                @foreach($services as $service)
                    <article class="reveal {{ 'stagger-'.(($loop->index % 4) + 1) }} premium-card rounded-[2rem] bg-white p-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#2EC4B6] text-sm font-bold text-slate-950">
                            {{ $loop->iteration < 10 ? '0'.$loop->iteration : $loop->iteration }}
                        </div>
                        <h3 class="mt-5 text-xl font-bold tracking-tight text-slate-950">{{ $service['title'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">{{ $service['desc'] }}</p>
                        <div class="mt-5 h-px w-full bg-gradient-to-r from-[#2EC4B6]/35 to-transparent"></div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-[#173F8A] py-24 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_14%_22%,rgba(255,255,255,0.08),transparent_18%),radial-gradient(circle_at_78%_20%,rgba(46,196,182,0.18),transparent_24%),radial-gradient(circle_at_65%_90%,rgba(255,255,255,0.05),transparent_20%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl reveal">
                    <p class="section-kicker text-sm font-semibold uppercase text-[#9CF7EF]">Phòng nổi bật</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">
                        Một số lựa chọn đang được khách hàng quan tâm
                    </h2>
                    <p class="mt-4 text-base leading-8 text-slate-100">
                        Khám phá nhanh các phòng hiện có để xem mức giá, sức chứa và đi đến trang chi tiết hoặc form đặt phòng nhanh hơn.
                    </p>
                </div>

                <a
                    href="{{ route('public.rooms.index') }}"
                    class="reveal inline-flex rounded-full border border-white/20 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition duration-300 hover:-translate-y-0.5 hover:bg-white/15"
                >
                    Xem toàn bộ danh sách
                </a>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($featuredRooms as $room)
                    @php
                        $roomImage = $featuredRoomImages[$loop->index % count($featuredRoomImages)];

                        $statusText = match($room->status) {
                            'available' => 'Còn phòng',
                            'booked' => 'Đã được đặt',
                            'occupied' => 'Đang sử dụng',
                            default => ucfirst($room->status),
                        };

                        $statusClass = match($room->status) {
                            'available' => 'bg-emerald-50 text-emerald-700',
                            'booked' => 'bg-amber-50 text-amber-700',
                            'occupied' => 'bg-rose-50 text-rose-700',
                            default => 'bg-slate-100 text-slate-700',
                        };
                    @endphp

                    <article class="reveal {{ 'stagger-'.(($loop->index % 3) + 1) }} overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-sm transition duration-300 hover:-translate-y-1.5 hover:shadow-[0_28px_50px_rgba(0,0,0,0.16)]">
                        <div class="img-hover relative h-56 overflow-hidden">
                            <img
                                src="{{ $roomImage }}"
                                alt="Hình ảnh phòng {{ $room->room_number }}"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/28 to-transparent"></div>
                            <div class="absolute right-4 top-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <p class="text-sm font-semibold text-[#9CF7EF]">{{ $room->roomType?->name }}</p>
                            <h3 class="mt-2 text-2xl font-bold tracking-tight text-white">Phòng {{ $room->room_number }}</h3>

                            <div class="mt-5 grid grid-cols-2 gap-4 rounded-3xl border border-white/10 bg-white/5 p-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-slate-300">Giá / đêm</p>
                                    <p class="mt-2 text-lg font-bold text-white">
                                        {{ number_format($room->roomType?->price ?? 0, 0, ',', '.') }} đ
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs uppercase tracking-wide text-slate-300">Sức chứa</p>
                                    <p class="mt-2 text-lg font-bold text-white">
                                        {{ $room->roomType?->capacity ?? 0 }} người
                                    </p>
                                </div>
                            </div>

                            <p class="mt-5 text-sm leading-7 text-slate-100">
                                {{ \Illuminate\Support\Str::limit($room->roomType?->description ?: 'Không gian lưu trú hiện đại, yên tĩnh và phù hợp cho nhiều mục đích chuyến đi khác nhau.', 110) }}
                            </p>

                            <div class="mt-6 flex gap-3">
                                <a
                                    href="{{ route('public.rooms.show', $room) }}"
                                    class="rounded-full border border-white/20 px-4 py-2.5 text-sm font-semibold text-white transition duration-300 hover:-translate-y-0.5 hover:bg-white/10"
                                >
                                    Xem chi tiết
                                </a>

                                <a
                                    href="{{ route('public.bookings.create', ['room' => $room->id]) }}"
                                    class="rounded-full bg-[#2EC4B6] px-4 py-2.5 text-sm font-semibold text-slate-950 transition duration-300 hover:-translate-y-0.5 hover:bg-[#27b0a3]"
                                >
                                    Đặt ngay
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-white/20 bg-white/5 p-10 text-center text-slate-100 md:col-span-2 xl:col-span-3">
                        Chưa có phòng nổi bật để hiển thị.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl reveal">
                <p class="section-kicker text-sm font-semibold uppercase text-[#173F8A]">Đánh giá khách hàng</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                    Phản hồi tích cực từ trải nghiệm lưu trú
                </h2>
                <p class="mt-4 text-base leading-8 text-slate-600">
                    Một hành trình đặt phòng tốt không chỉ đẹp về giao diện mà còn cần rõ ràng, thuận tiện và tạo được sự an tâm trong từng bước sử dụng.
                </p>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @foreach($testimonials as $review)
                    <article class="reveal {{ 'stagger-'.(($loop->index % 3) + 1) }} premium-card rounded-[2rem] bg-slate-50 p-7">
                        <div class="flex items-center gap-1 text-[#2EC4B6]">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <p class="mt-5 text-base leading-8 text-slate-700">
                            “{{ $review['content'] }}”
                        </p>
                        <div class="mt-6 border-t border-slate-200 pt-5">
                            <p class="font-bold text-slate-950">{{ $review['name'] }}</p>
                            <p class="text-sm text-slate-500">{{ $review['type'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="reveal">
                <p class="section-kicker text-sm font-semibold uppercase text-[#173F8A]">Câu hỏi thường gặp</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                    Giải đáp nhanh trước khi bạn gửi booking
                </h2>
                <p class="mt-4 text-base leading-8 text-slate-600">
                    Những câu hỏi phổ biến giúp khách hàng hiểu rõ hơn về quy trình đặt phòng, trạng thái booking và cách tra cứu lại thông tin.
                </p>
            </div>

            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <details class="faq-item reveal {{ 'stagger-'.(($loop->index % 4) + 1) }} rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition duration-300">
                        <summary class="cursor-pointer list-none pr-8 text-lg font-bold text-slate-950">
                            {{ $faq['q'] }}
                        </summary>
                        <p class="mt-4 text-sm leading-7 text-slate-600">
                            {{ $faq['a'] }}
                        </p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-slate-100 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl reveal">
                    <p class="section-kicker text-sm font-semibold uppercase text-[#173F8A]">Cẩm nang lưu trú</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                        Gợi ý hữu ích cho chuyến đi thuận tiện và thoải mái hơn
                    </h2>
                    <p class="mt-4 text-base leading-8 text-slate-600">
                        Những nội dung ngắn gọn giúp khách hàng dễ chọn phòng hơn và chủ động hơn trong quá trình chuẩn bị chuyến đi.
                    </p>
                </div>

                <a
                    href="{{ route('public.news.index') }}"
                    class="reveal inline-flex rounded-full border border-[#173F8A]/15 px-5 py-3 text-sm font-semibold text-[#173F8A] transition duration-300 hover:-translate-y-0.5 hover:bg-white"
                >
                    Xem tất cả bài viết
                </a>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @foreach($newsItems as $item)
                    <article class="reveal {{ 'stagger-'.(($loop->index % 3) + 1) }} premium-card overflow-hidden rounded-[2rem] bg-white">
                        <div class="img-hover h-60 overflow-hidden">
                            <img
                                src="{{ $item['image'] }}"
                                alt="{{ $item['title'] }}"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >
                        </div>

                        <div class="p-6">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#173F8A]">{{ $item['category'] }}</p>
                            <h3 class="mt-3 text-2xl font-bold leading-tight tracking-tight text-slate-950">
                                {{ $item['title'] }}
                            </h3>
                            <p class="mt-4 text-sm leading-7 text-slate-600">
                                {{ $item['desc'] }}
                            </p>

                            <a
                                href="{{ route('public.news.show', ['slug' => $item['slug']]) }}"
                                class="mt-6 inline-flex rounded-full border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition duration-300 hover:-translate-y-0.5 hover:bg-slate-50"
                            >
                                Đọc bài viết
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pt-24 pb-28 sm:px-6 lg:px-8">
        <div class="reveal overflow-hidden rounded-[2.5rem] bg-[#173F8A] px-6 py-12 text-white shadow-[0_30px_80px_rgba(8,26,69,0.18)] sm:px-10 sm:py-14 lg:px-12 lg:py-16">
            <div class="grid gap-8 lg:grid-cols-[1fr_0.8fr] lg:items-center">
                <div>
                    <p class="section-kicker text-sm font-semibold uppercase text-[#9CF7EF]">
                        Sẵn sàng cho chuyến đi của bạn?
                    </p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">
                        Tìm phòng phù hợp hoặc tra cứu booking chỉ trong vài thao tác
                    </h2>
                    <p class="mt-4 max-w-2xl text-base leading-8 text-slate-100">
                        Chúng tôi mang đến trải nghiệm đặt phòng rõ ràng, tinh tế và thuận tiện để mỗi hành trình bắt đầu một cách nhẹ nhàng hơn.
                    </p>
                </div>

                <div class="flex flex-wrap gap-4 lg:justify-end">
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-slate-950 transition duration-300 hover:-translate-y-0.5 hover:bg-[#27b0a3]"
                    >
                        Khám phá phòng
                    </a>

                    <a
                        href="{{ route('public.bookings.lookup') }}"
                        class="rounded-full border border-white/20 bg-white/10 px-6 py-3 text-sm font-semibold text-white transition duration-300 hover:-translate-y-0.5 hover:bg-white/15"
                    >
                        Tra cứu booking
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reveals = document.querySelectorAll('.reveal');

            if (!('IntersectionObserver' in window)) {
                reveals.forEach(el => el.classList.add('is-visible'));
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.14,
                rootMargin: '0px 0px -40px 0px'
            });

            reveals.forEach((el, index) => {
                if (index < 2) {
                    el.classList.add('is-visible');
                } else {
                    observer.observe(el);
                }
            });
        });
    </script>
</x-layouts.public>