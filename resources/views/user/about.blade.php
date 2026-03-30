@php
    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroBackground = $assetOrFallback(
        'images/user/about-hero.jpg',
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80'
    );

    $aboutImage = $assetOrFallback(
        'images/user/about-cover.jpg',
        'https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8?auto=format&fit=crop&w=1600&q=80'
    );

    $secondaryImage = $assetOrFallback(
        'images/user/about-secondary.jpg',
        'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=1200&q=80'
    );

    $experienceHighlights = [
        [
            'title' => 'Khám phá dễ dàng',
            'desc' => 'Danh sách phòng, chi tiết phòng và thông tin lưu trú được trình bày rõ ràng để người dùng ra quyết định nhanh hơn.',
        ],
        [
            'title' => 'Đặt phòng liền mạch',
            'desc' => 'Luồng chọn phòng, gửi booking và theo dõi lại trạng thái được kết nối xuyên suốt trên cùng một trải nghiệm.',
        ],
        [
            'title' => 'Theo dõi minh bạch',
            'desc' => 'Người dùng có thể tra cứu booking, kiểm tra trạng thái xác nhận và thông tin thanh toán bất cứ khi nào cần.',
        ],
    ];

    $journeyBlocks = [
        [
            'title' => 'Từ lúc khám phá đến lúc gửi booking',
            'desc' => 'Website được xây dựng để người dùng có thể xem phòng, so sánh lựa chọn, chọn ngày lưu trú và gửi yêu cầu đặt phòng một cách tự nhiên, không bị rối mắt hay thiếu thông tin.',
        ],
        [
            'title' => 'Từ trải nghiệm đẹp đến vận hành thực tế',
            'desc' => 'Phía sau giao diện là logic bám sát nghiệp vụ khách sạn như trạng thái phòng, lịch lưu trú, booking và thanh toán, giúp trải nghiệm đẹp nhưng vẫn có nền tảng để triển khai lâu dài.',
        ],
    ];

    $heroStats = [
        ['label' => 'Trọng tâm', 'value' => 'Trải nghiệm đặt phòng rõ ràng'],
        ['label' => 'Định hướng', 'value' => 'Hiện đại · Sang trọng · Liền mạch'],
        ['label' => 'Mục tiêu', 'value' => 'Sẵn sàng cho website vận hành thực tế'],
    ];
@endphp

<x-layouts.public
    title="Giới thiệu | Navara Boutique Hotel"
    metaDescription="Tìm hiểu về Navara Boutique Hotel, định hướng trải nghiệm đặt phòng, tiện ích lưu trú và những giá trị nổi bật của website khách sạn."
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

        .about-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .about-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .about-hero {
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

        .about-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(46, 196, 182, 0.12), transparent 24%),
                linear-gradient(to top, rgba(8, 26, 69, 0.16), rgba(8, 26, 69, 0.02));
            pointer-events: none;
        }

        .about-hero-badge {
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
        }

        .about-hero-panel {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(9, 26, 64, 0.14);
            box-shadow: 0 28px 70px rgba(5, 15, 40, 0.18);
            backdrop-filter: blur(8px);
        }

        .about-hero-inner-card {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(8, 26, 69, 0.16);
        }

        .about-highlight-card {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        }

        .about-highlight-card:hover {
            transform: translateY(-8px);
            border-color: rgba(23, 63, 138, 0.16);
            box-shadow: var(--navara-shadow-lg);
        }

        .about-highlight-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,.06) 45%, rgba(255,255,255,.20) 50%, transparent 55%);
            transform: translateX(-130%) skewX(-18deg);
            pointer-events: none;
        }

        .about-highlight-card:hover::after {
            animation: shineSweep .9s ease;
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

        .nav-btn-hover {
            transition: transform .28s ease, box-shadow .28s ease, background-color .28s ease, border-color .28s ease, color .28s ease;
        }

        .nav-btn-hover:hover {
            transform: translateY(-2px);
        }

        @media (prefers-reduced-motion: reduce) {
            .about-floating-orb,
            .hero-copy-reveal,
            .hero-panel-reveal,
            .hero-stats-reveal,
            .reveal-on-scroll,
            .reveal-on-scroll.is-visible,
            .about-highlight-card,
            .about-highlight-card::after,
            .nav-btn-hover {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>

    <section class="about-hero min-h-[700px] lg:min-h-[760px]">
        <div class="about-floating-orb absolute -left-16 top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        <div class="about-floating-orb absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="hero-copy-reveal">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">Giới thiệu</span>
                    </div>

                    <div class="mt-6 inline-flex about-hero-badge rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">
                        Giới thiệu Navara Boutique Hotel
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[3.9rem] lg:leading-[1.04]">
                        Một trải nghiệm đặt phòng được xây dựng theo hướng hiện đại, sang trọng và dễ sử dụng.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        Website tập trung vào việc giúp người dùng khám phá hạng phòng, kiểm tra lịch lưu trú, gửi booking và tra cứu lại trạng thái sau khi đặt trong một hành trình liền mạch, rõ ràng và đáng tin cậy.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Khám phá phòng nghỉ
                        </a>

                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Tra cứu booking
                        </a>
                    </div>
                </div>

                <div class="hero-panel-reveal about-hero-panel overflow-hidden rounded-[2rem] p-4 sm:p-5 lg:p-6">
                    <div class="about-hero-inner-card rounded-[1.75rem] p-6 text-slate-900 sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Định hướng trải nghiệm</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                                    Mọi thành phần được tối ưu để người dùng dễ hiểu và dễ thao tác
                                </h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Tinh thần thiết kế</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">Chỉn chu · Gọn gàng · Liền mạch</p>
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
                            Không chỉ đẹp về giao diện, website còn được tổ chức theo hướng có thể phát triển thành nền tảng khách sạn vận hành thực tế, từ khâu xem phòng đến khâu theo dõi booking.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-10 lg:grid-cols-[1fr_0.95fr] lg:items-center">
            <div class="reveal-on-scroll reveal-delay-1">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tầm nhìn trải nghiệm</p>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                    Tập trung vào luồng đặt phòng trực quan và dễ theo dõi
                </h2>
                <div class="mt-6 space-y-5 text-base leading-8 text-slate-600">
                    <p>
                        Website user side được thiết kế theo tinh thần của các nền tảng đặt phòng hiện đại: nội dung rõ ràng, hình ảnh nhiều hơn, thông tin phòng chi tiết hơn và có thêm các khối nội dung hỗ trợ như giới thiệu, tin tức, liên hệ và khu vực tra cứu booking.
                    </p>
                    <p>
                        Không chỉ dừng ở giao diện, hệ thống còn bám vào các luồng vận hành thực tế như kiểm tra lịch lưu trú, quản lý trạng thái phòng, tiếp nhận booking và theo dõi thanh toán, giúp trải nghiệm người dùng và logic hệ thống đi cùng nhau.
                    </p>
                    <p>
                        Điều này tạo nền tảng để website không chỉ đẹp khi demo mà còn có khả năng phát triển tiếp theo hướng website khách sạn hoàn chỉnh trong tương lai.
                    </p>
                </div>
            </div>

            <div class="reveal-on-scroll reveal-delay-2 grid gap-4 sm:grid-cols-2">
                @foreach($milestones as $item)
                    <div class="about-shell-card rounded-[2rem] bg-white p-6">
                        <p class="text-3xl font-black text-slate-900">{{ $item['number'] }}</p>
                        <p class="mt-3 text-sm font-semibold text-slate-600">{{ $item['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-slate-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div class="reveal-on-scroll reveal-delay-1">
                    <div class="overflow-hidden rounded-[2.2rem]">
                        <img
                            src="{{ $aboutImage }}"
                            alt="Không gian lưu trú cao cấp"
                            class="h-[460px] w-full object-cover"
                        >
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 space-y-5">
                    @foreach($journeyBlocks as $block)
                        <div class="about-shell-card rounded-[2rem] bg-white p-6 sm:p-7">
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#173F8A]">{{ $block['title'] }}</p>
                            <p class="mt-4 text-sm leading-7 text-slate-600">{{ $block['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl reveal-on-scroll reveal-delay-1">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Điểm nổi bật</p>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                    Những giá trị chính của hệ thống
                </h2>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach($features as $feature)
                    <article class="about-highlight-card reveal-on-scroll rounded-[2rem] bg-slate-50 p-6" style="animation-delay: {{ 0.04 * $loop->index }}s;">
                        <h3 class="text-xl font-black text-slate-900">{{ $feature['title'] }}</h3>
                        <p class="mt-4 text-sm leading-7 text-slate-600">{{ $feature['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-center">
            <div class="reveal-on-scroll reveal-delay-1 overflow-hidden rounded-[2.2rem]">
                <img
                    src="{{ $secondaryImage }}"
                    alt="Trải nghiệm đặt phòng hiện đại"
                    class="h-[420px] w-full object-cover"
                >
            </div>

            <div class="space-y-5">
                @foreach($experienceHighlights as $item)
                    <div class="reveal-on-scroll about-shell-card rounded-[2rem] bg-white p-6 sm:p-7" style="animation-delay: {{ 0.08 * $loop->index }}s;">
                        <p class="text-lg font-black text-slate-900">{{ $item['title'] }}</p>
                        <p class="mt-3 text-sm leading-7 text-slate-600">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="reveal-on-scroll overflow-hidden rounded-[2.5rem] bg-[#081A45] px-8 py-12 text-white sm:px-10 sm:py-14">
                <div class="grid gap-8 lg:grid-cols-[1fr_0.82fr] lg:items-center">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#9ff4ec]">Khám phá thêm</p>
                        <h2 class="mt-3 text-3xl font-black tracking-tight">
                            Xem phòng, đọc tin tức hoặc tra cứu booking ngay trên website
                        </h2>
                        <p class="mt-4 max-w-2xl text-slate-300">
                            Sau khi hoàn thiện phần nội dung giới thiệu, trải nghiệm website trở nên đầy đủ hơn cả ở góc nhìn khám phá, đặt phòng lẫn hỗ trợ nội dung cho SEO on-page.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-4 lg:justify-end">
                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="nav-btn-hover rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Xem danh sách phòng
                        </a>
                        <a
                            href="{{ route('public.news.index') }}"
                            class="nav-btn-hover rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/20"
                        >
                            Đọc tin tức
                        </a>
                    </div>
                </div>
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