@php
    use Carbon\Carbon;

    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroBackground = $assetOrFallback(
        'images/user/news-hero.jpg',
        'https://images.unsplash.com/photo-1496417263034-38ec4f0b665a?auto=format&fit=crop&w=1800&q=80'
    );

    $newsCollection = collect($newsItems ?? []);
    $featuredArticle = $newsCollection->first();
    $secondaryArticles = $newsCollection->slice(1)->values();
    $categoriesCount = $newsCollection->pluck('category')->filter()->unique()->count();

    $heroStats = [
        ['label' => 'Bài viết', 'value' => $newsCollection->count()],
        ['label' => 'Chuyên mục', 'value' => $categoriesCount],
        ['label' => 'Mục tiêu', 'value' => 'Nội dung hữu ích + SEO'],
    ];

    $contentHighlights = [
        [
            'title' => 'Kinh nghiệm chọn phòng',
            'desc' => 'Gợi ý giúp người dùng chọn hạng phòng phù hợp hơn theo nhu cầu, ngân sách và thời gian lưu trú.',
        ],
        [
            'title' => 'Cẩm nang lưu trú',
            'desc' => 'Những nội dung dễ đọc, thực tế và hỗ trợ người dùng chuẩn bị tốt hơn trước khi đặt phòng.',
        ],
        [
            'title' => 'Gia tăng độ tin cậy',
            'desc' => 'Khu vực tin tức giúp website không chỉ có chức năng mà còn có chiều sâu nội dung và thương hiệu.',
        ],
    ];
@endphp

<x-layouts.public
    title="Tin tức & Cẩm nang | Navara Boutique Hotel"
    metaDescription="Khám phá các bài viết về kinh nghiệm đặt phòng, lưu trú, cẩm nang du lịch và hướng dẫn sử dụng website Navara Boutique Hotel."
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

        .news-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .news-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .news-hero {
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

        .news-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(46, 196, 182, 0.12), transparent 24%),
                linear-gradient(to top, rgba(8, 26, 69, 0.16), rgba(8, 26, 69, 0.02));
            pointer-events: none;
        }

        .news-hero-badge {
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
        }

        .news-hero-panel {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(9, 26, 64, 0.14);
            box-shadow: 0 28px 70px rgba(5, 15, 40, 0.18);
            backdrop-filter: blur(8px);
        }

        .news-hero-inner-card {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(8, 26, 69, 0.16);
        }

        .news-card {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
        }

        .news-card:hover {
            transform: translateY(-8px);
            border-color: rgba(23, 63, 138, 0.16);
            box-shadow: var(--navara-shadow-lg);
        }

        .news-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,.06) 45%, rgba(255,255,255,.20) 50%, transparent 55%);
            transform: translateX(-130%) skewX(-18deg);
            pointer-events: none;
        }

        .news-card:hover::after {
            animation: shineSweep .9s ease;
        }

        .news-card img {
            transition: transform .8s ease;
        }

        .news-card:hover img {
            transform: scale(1.06);
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
            .news-floating-orb,
            .hero-copy-reveal,
            .hero-panel-reveal,
            .hero-stats-reveal,
            .reveal-on-scroll,
            .reveal-on-scroll.is-visible,
            .news-card,
            .news-card::after,
            .news-card img,
            .nav-btn-hover {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>

    <section class="news-hero min-h-[700px] lg:min-h-[760px]">
        <div class="news-floating-orb absolute -left-16 top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        <div class="news-floating-orb absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="hero-copy-reveal">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">Tin tức & cẩm nang</span>
                    </div>

                    <div class="mt-6 inline-flex news-hero-badge rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">
                        Tin tức & cẩm nang lưu trú
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[3.9rem] lg:leading-[1.04]">
                        Nội dung hữu ích giúp website giàu thông tin hơn và hỗ trợ SEO tốt hơn.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        Các bài viết trong khu vực này giúp người dùng hiểu rõ hơn về cách chọn phòng, thời điểm đặt phòng, trải nghiệm lưu trú và những lưu ý quan trọng trước khi ra quyết định.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="#news-list"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Xem bài viết
                        </a>

                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Xem phòng nghỉ
                        </a>
                    </div>
                </div>

                <div class="hero-panel-reveal news-hero-panel overflow-hidden rounded-[2rem] p-4 sm:p-5 lg:p-6">
                    <div class="news-hero-inner-card rounded-[1.75rem] p-6 text-slate-900 sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Chiến lược nội dung</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                                    Nội dung không chỉ để đọc mà còn hỗ trợ trải nghiệm và thương hiệu
                                </h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Hướng triển khai</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">Hữu ích · Dễ đọc · Chuẩn chỉn</p>
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
                            Khu vực tin tức giúp website trở nên đầy đặn hơn về nội dung, nâng cảm giác chuyên nghiệp và tạo nền tảng tốt hơn cho SEO on-page về lâu dài.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($featuredArticle)
        <section class="mx-auto max-w-7xl px-4 pt-12 sm:px-6 lg:px-8 lg:pt-16">
            <div class="reveal-on-scroll reveal-delay-1 news-shell-card overflow-hidden rounded-[2.2rem] bg-white">
                <div class="grid gap-0 lg:grid-cols-[1.05fr_0.95fr]">
                    <div class="relative min-h-[360px] overflow-hidden">
                        <img
                            src="{{ $featuredArticle['image'] }}"
                            alt="{{ $featuredArticle['title'] }}"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-[#081A45]/75 via-[#081A45]/18 to-transparent"></div>

                        <div class="absolute left-6 top-6">
                            <span class="inline-flex rounded-full bg-white/95 px-3.5 py-1.5 text-xs font-extrabold uppercase tracking-[0.18em] text-[#0B245B] shadow-sm">
                                Bài viết nổi bật
                            </span>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 lg:p-10">
                        <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                            <span>{{ $featuredArticle['category'] }}</span>
                            <span>•</span>
                            <span>{{ Carbon::parse($featuredArticle['date'])->format('d/m/Y') }}</span>
                            <span>•</span>
                            <span>{{ $featuredArticle['read_time'] }}</span>
                        </div>

                        <h2 class="mt-5 text-3xl font-black leading-tight tracking-tight text-slate-900 sm:text-[2.1rem]">
                            {{ $featuredArticle['title'] }}
                        </h2>

                        <p class="mt-5 text-base leading-8 text-slate-600">
                            {{ $featuredArticle['excerpt'] }}
                        </p>

                        <div class="mt-8 flex flex-wrap gap-4">
                            <a
                                href="{{ route('public.news.show', $featuredArticle['slug']) }}"
                                class="nav-btn-hover inline-flex rounded-full bg-[#173F8A] px-6 py-3 text-sm font-semibold text-white hover:bg-[#143374]"
                            >
                                Đọc chi tiết
                            </a>

                            <a
                                href="{{ route('public.rooms.index') }}"
                                class="nav-btn-hover inline-flex rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                            >
                                Xem phòng nghỉ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="bg-slate-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-3">
                @foreach($contentHighlights as $item)
                    <article class="news-card reveal-on-scroll rounded-[2rem] bg-white p-6" style="animation-delay: {{ 0.05 * $loop->index }}s;">
                        <h3 class="text-xl font-black text-slate-900">{{ $item['title'] }}</h3>
                        <p class="mt-4 text-sm leading-7 text-slate-600">{{ $item['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="news-list" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="max-w-3xl reveal-on-scroll reveal-delay-1">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Danh sách bài viết</p>
            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                Nội dung giúp người dùng hiểu rõ hơn trước khi đặt phòng
            </h2>
        </div>

        @if($newsCollection->isNotEmpty())
            <div class="mt-10 grid gap-8 lg:grid-cols-3">
                @foreach($newsCollection as $article)
                    <article class="news-card reveal-on-scroll overflow-hidden rounded-[2rem] bg-white" style="animation-delay: {{ 0.04 * $loop->index }}s;">
                        <div class="h-60 overflow-hidden">
                            <img
                                src="{{ $article['image'] }}"
                                alt="{{ $article['title'] }}"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >
                        </div>

                        <div class="p-6">
                            <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                                <span>{{ $article['category'] }}</span>
                                <span>•</span>
                                <span>{{ Carbon::parse($article['date'])->format('d/m/Y') }}</span>
                                <span>•</span>
                                <span>{{ $article['read_time'] }}</span>
                            </div>

                            <h3 class="mt-4 text-2xl font-black leading-tight text-slate-900">
                                {{ $article['title'] }}
                            </h3>

                            <p class="mt-4 text-sm leading-7 text-slate-600">
                                {{ $article['excerpt'] }}
                            </p>

                            <a
                                href="{{ route('public.news.show', $article['slug']) }}"
                                class="nav-btn-hover mt-6 inline-flex rounded-full bg-[#173F8A] px-5 py-3 text-sm font-semibold text-white hover:bg-[#143374]"
                            >
                                Đọc chi tiết
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="reveal-on-scroll mt-10 news-shell-card rounded-[2rem] border-dashed bg-white p-10 text-center">
                <h3 class="text-2xl font-black text-slate-900">Chưa có bài viết để hiển thị</h3>
                <p class="mt-4 text-sm leading-7 text-slate-600">
                    Khu vực tin tức sẽ được cập nhật thêm nội dung về kinh nghiệm chọn phòng, lưu trú và cẩm nang du lịch trong các bước hoàn thiện tiếp theo.
                </p>
            </div>
        @endif
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