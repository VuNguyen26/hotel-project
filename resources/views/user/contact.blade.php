@php
    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroBackground = $assetOrFallback(
        'images/user/contact-hero.jpg',
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=80'
    );

    $contactCover = $assetOrFallback(
        'images/user/contact-cover.jpg',
        'https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8?auto=format&fit=crop&w=1600&q=80'
    );

    $contactCards = [
        [
            'label' => 'Địa chỉ',
            'value' => $contactInfo['address'],
            'icon' => '📍',
        ],
        [
            'label' => 'Số điện thoại',
            'value' => $contactInfo['phone'],
            'icon' => '📞',
        ],
        [
            'label' => 'Email',
            'value' => $contactInfo['email'],
            'icon' => '✉️',
        ],
        [
            'label' => 'Thời gian hỗ trợ',
            'value' => $contactInfo['hours'],
            'icon' => '🕘',
        ],
    ];

    $heroStats = [
        ['label' => 'Hỗ trợ', 'value' => 'Thông tin rõ ràng'],
        ['label' => 'Mục tiêu', 'value' => 'Tăng độ tin cậy'],
        ['label' => 'Trải nghiệm', 'value' => 'Nhanh · Gọn · Liền mạch'],
    ];

    $supportHighlights = [
        [
            'title' => 'Liên hệ nhanh',
            'desc' => 'Cung cấp đầy đủ thông tin để người dùng có thể gọi điện, gửi email hoặc tìm đường dễ dàng hơn.',
        ],
        [
            'title' => 'Tăng độ tin cậy',
            'desc' => 'Một trang liên hệ rõ ràng giúp website tạo cảm giác chỉn chu và chuyên nghiệp hơn trong mắt khách hàng.',
        ],
        [
            'title' => 'Hỗ trợ hành trình đặt phòng',
            'desc' => 'Người dùng có thể quay lại xem phòng hoặc tra cứu booking ngay từ trang liên hệ khi cần hỗ trợ thêm.',
        ],
    ];
@endphp

<x-layouts.public 
    title="Liên hệ | Navara Boutique Hotel"
    metaDescription="Thông tin liên hệ, hỗ trợ cơ bản và giải đáp nhanh cho khách hàng khi sử dụng website Navara Boutique Hotel."
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

        .contact-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .contact-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .contact-hero {
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

        .contact-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(46, 196, 182, 0.12), transparent 24%),
                linear-gradient(to top, rgba(8, 26, 69, 0.16), rgba(8, 26, 69, 0.02));
            pointer-events: none;
        }

        .contact-hero-badge {
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
        }

        .contact-hero-panel {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(9, 26, 64, 0.14);
            box-shadow: 0 28px 70px rgba(5, 15, 40, 0.18);
            backdrop-filter: blur(8px);
        }

        .contact-hero-inner-card {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(8, 26, 69, 0.16);
        }

        .contact-highlight-card {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        }

        .contact-highlight-card:hover {
            transform: translateY(-8px);
            border-color: rgba(23, 63, 138, 0.16);
            box-shadow: var(--navara-shadow-lg);
        }

        .contact-highlight-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,.06) 45%, rgba(255,255,255,.20) 50%, transparent 55%);
            transform: translateX(-130%) skewX(-18deg);
            pointer-events: none;
        }

        .contact-highlight-card:hover::after {
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
            .contact-floating-orb,
            .hero-copy-reveal,
            .hero-panel-reveal,
            .hero-stats-reveal,
            .reveal-on-scroll,
            .reveal-on-scroll.is-visible,
            .contact-highlight-card,
            .contact-highlight-card::after,
            .nav-btn-hover {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>

    <section class="contact-hero min-h-[700px] lg:min-h-[760px]">
        <div class="contact-floating-orb absolute -left-16 top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        <div class="contact-floating-orb absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="hero-copy-reveal">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">Liên hệ</span>
                    </div>

                    <div class="mt-6 inline-flex contact-hero-badge rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">
                        Liên hệ & hỗ trợ
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[3.9rem] lg:leading-[1.04]">
                        Kết nối với chúng tôi để được hỗ trợ nhanh hơn trong hành trình đặt phòng.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        Trang liên hệ giúp website đầy đủ hơn về mặt trải nghiệm, tăng cảm giác tin cậy và tạo thêm điểm chạm rõ ràng để khách hàng tìm hiểu hoặc cần hỗ trợ khi sử dụng website.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Xem phòng nghỉ
                        </a>

                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Tra cứu booking
                        </a>
                    </div>
                </div>

                <div class="hero-panel-reveal contact-hero-panel overflow-hidden rounded-[2rem] p-4 sm:p-5 lg:p-6">
                    <div class="contact-hero-inner-card rounded-[1.75rem] p-6 text-slate-900 sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Hỗ trợ cơ bản</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                                    Mọi thông tin cần thiết được gom lại rõ ràng
                                </h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Ưu tiên</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">Nhanh · Rõ · Dễ tìm</p>
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
                            Không chỉ đóng vai trò thông tin, trang liên hệ còn giúp website hoàn chỉnh hơn về độ tin cậy thương hiệu và khả năng mở rộng SEO địa phương trong các giai đoạn tiếp theo.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="space-y-6">
                <div class="reveal-on-scroll reveal-delay-1 contact-shell-card overflow-hidden rounded-[2rem] bg-white">
                    <div class="relative min-h-[280px] overflow-hidden">
                        <img
                            src="{{ $contactCover }}"
                            alt="Liên hệ khách sạn"
                            class="h-full w-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-[#081A45]/80 via-[#081A45]/18 to-transparent"></div>

                        <div class="absolute inset-x-6 bottom-6 text-white">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-white/70">Thông tin liên hệ</p>
                            <h2 class="mt-2 text-3xl font-black">Luôn sẵn sàng hỗ trợ khi anh cần thêm thông tin</h2>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="grid gap-4 md:grid-cols-2">
                            @foreach($contactCards as $item)
                                <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                                    <div class="text-2xl">{{ $item['icon'] }}</div>
                                    <p class="mt-4 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $item['label'] }}</p>
                                    <p class="mt-2 text-sm leading-7 text-slate-800">{{ $item['value'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 contact-shell-card rounded-[2rem] border border-[#173F8A]/10 bg-[linear-gradient(135deg,rgba(23,63,138,0.05),rgba(46,196,182,0.08))] p-6 sm:p-7">
                    <h3 class="text-2xl font-black text-slate-900">Bạn có thể bắt đầu từ đây</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-600">
                        Nếu đang tìm phòng hoặc cần kiểm tra lại thông tin booking, anh có thể đi nhanh tới đúng khu vực ngay bên dưới.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-4">
                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="nav-btn-hover rounded-full bg-[#173F8A] px-6 py-3 text-sm font-semibold text-white hover:bg-[#143374]"
                        >
                            Xem phòng
                        </a>
                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100"
                        >
                            Tra cứu booking
                        </a>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    @foreach($supportHighlights as $item)
                        <article class="contact-highlight-card reveal-on-scroll rounded-[2rem] bg-white p-5" style="animation-delay: {{ 0.05 * $loop->index }}s;">
                            <h3 class="text-lg font-black text-slate-900">{{ $item['title'] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $item['desc'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="reveal-on-scroll reveal-delay-1 contact-shell-card rounded-[2rem] bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-black text-slate-900">Câu hỏi thường gặp</h2>

                <div class="mt-8 space-y-4">
                    @foreach($faqs as $faq)
                        <details class="group rounded-[1.8rem] border border-slate-200 bg-slate-50 p-5">
                            <summary class="cursor-pointer list-none text-lg font-black text-slate-900">
                                {{ $faq['q'] }}
                            </summary>
                            <p class="mt-4 text-sm leading-7 text-slate-600">
                                {{ $faq['a'] }}
                            </p>
                        </details>
                    @endforeach
                </div>

                <div class="mt-8 rounded-[1.8rem] border border-dashed border-slate-300 bg-slate-50 p-6 text-sm leading-7 text-slate-600">
                    Trang liên hệ hiện đóng vai trò như một khu vực hỗ trợ cơ bản để hoàn thiện trải nghiệm website. Ở giai đoạn tiếp theo, anh có thể nâng cấp thêm form gửi liên hệ thật, Google Map nhúng, social links và schema LocalBusiness để tăng hiệu quả SEO địa phương.
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