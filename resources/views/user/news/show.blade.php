@php
    use Carbon\Carbon;

    $articleDate = Carbon::parse($article['date'])->format('d/m/Y');
    $contentBlocks = $article['content'] ?? [];
@endphp

<x-layouts.public
    title="{{ $article['title'] }} | Navara Boutique Hotel"
    metaDescription="{{ $article['excerpt'] }}"
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

        .news-show-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .news-show-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .news-show-hero {
            position: relative;
            overflow: hidden;
            color: white;
            background-image:
                linear-gradient(
                    90deg,
                    rgba(8, 26, 69, 0.68) 0%,
                    rgba(8, 26, 69, 0.56) 34%,
                    rgba(13, 37, 92, 0.44) 68%,
                    rgba(13, 37, 92, 0.30) 100%
                ),
                url('{{ $article['image'] }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .news-show-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at top right, rgba(46, 196, 182, 0.12), transparent 24%),
                linear-gradient(to top, rgba(8, 26, 69, 0.16), rgba(8, 26, 69, 0.02));
            pointer-events: none;
        }

        .news-show-hero-badge {
            border: 1px solid rgba(255, 255, 255, 0.16);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
        }

        .news-show-hero-panel {
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(9, 26, 64, 0.14);
            box-shadow: 0 28px 70px rgba(5, 15, 40, 0.18);
            backdrop-filter: blur(8px);
        }

        .news-show-hero-inner-card {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 24px 60px rgba(8, 26, 69, 0.16);
        }

        .news-related-card {
            position: relative;
            overflow: hidden;
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease, background-color .35s ease;
        }

        .news-related-card:hover {
            transform: translateY(-6px);
            border-color: rgba(23, 63, 138, 0.16);
            box-shadow: var(--navara-shadow-lg);
            background: #f8fbff;
        }

        .news-related-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 0%, rgba(255,255,255,.06) 45%, rgba(255,255,255,.18) 50%, transparent 55%);
            transform: translateX(-130%) skewX(-18deg);
            pointer-events: none;
        }

        .news-related-card:hover::after {
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

        .news-article-prose p {
            margin-bottom: 1.25rem;
            font-size: 1rem;
            line-height: 2rem;
            color: #475569;
        }

        @media (prefers-reduced-motion: reduce) {
            .news-show-floating-orb,
            .hero-copy-reveal,
            .hero-panel-reveal,
            .reveal-on-scroll,
            .reveal-on-scroll.is-visible,
            .news-related-card,
            .news-related-card::after,
            .nav-btn-hover {
                animation: none !important;
                transition: none !important;
                transform: none !important;
                opacity: 1 !important;
            }
        }
    </style>

    <section class="news-show-hero min-h-[700px] lg:min-h-[760px]">
        <div class="news-show-floating-orb absolute -left-16 top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        <div class="news-show-floating-orb absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div class="hero-copy-reveal">
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <a href="{{ route('public.news.index') }}" class="transition hover:text-white">Tin tức</a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">{{ $article['title'] }}</span>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <span class="news-show-hero-badge rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">
                            {{ $article['category'] }}
                        </span>
                        <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold text-white/90">
                            {{ $articleDate }} · {{ $article['read_time'] }}
                        </span>
                    </div>

                    <h1 class="mt-6 max-w-4xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[3.9rem] lg:leading-[1.04]">
                        {{ $article['title'] }}
                    </h1>

                    <p class="mt-6 max-w-3xl text-base leading-8 text-slate-200 sm:text-lg">
                        {{ $article['excerpt'] }}
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="#article-content"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Đọc bài viết
                        </a>

                        <a
                            href="{{ route('public.news.index') }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Quay lại tin tức
                        </a>
                    </div>
                </div>

                <div class="hero-panel-reveal news-show-hero-panel overflow-hidden rounded-[2rem] p-4 sm:p-5 lg:p-6">
                    <div class="news-show-hero-inner-card rounded-[1.75rem] p-6 text-slate-900 sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tóm tắt bài viết</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                                    Nội dung được trình bày rõ ràng, dễ đọc và dễ áp dụng
                                </h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Chuyên mục</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">{{ $article['category'] }}</p>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3">
                            <div class="rounded-[1.4rem] border border-slate-200 bg-white p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Ngày đăng</p>
                                <p class="mt-2 text-lg font-black text-slate-900">{{ $articleDate }}</p>
                            </div>
                            <div class="rounded-[1.4rem] border border-slate-200 bg-white p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Thời gian đọc</p>
                                <p class="mt-2 text-lg font-black text-slate-900">{{ $article['read_time'] }}</p>
                            </div>
                            <div class="rounded-[1.4rem] border border-slate-200 bg-white p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Mục đích</p>
                                <p class="mt-2 text-lg font-black text-slate-900">Hữu ích · Thực tế · Dễ tiếp cận</p>
                            </div>
                        </div>

                        <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                            Khu vực bài viết giúp website không chỉ có chức năng đặt phòng mà còn có chiều sâu nội dung, tăng độ chuyên nghiệp và hỗ trợ người dùng tốt hơn trước khi ra quyết định.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="article-content" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_340px]">
            <article class="reveal-on-scroll reveal-delay-1 news-show-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                <div class="overflow-hidden rounded-[2rem]">
                    <img
                        src="{{ $article['image'] }}"
                        alt="{{ $article['title'] }}"
                        class="h-[360px] w-full object-cover"
                    >
                </div>

                <div class="mt-8 flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                    <span>{{ $article['category'] }}</span>
                    <span>•</span>
                    <span>{{ $articleDate }}</span>
                    <span>•</span>
                    <span>{{ $article['read_time'] }}</span>
                </div>

                <div class="news-article-prose mt-8 max-w-none">
                    @foreach($contentBlocks as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a
                        href="{{ route('public.news.index') }}"
                        class="nav-btn-hover inline-flex rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100"
                    >
                        ← Quay lại tin tức
                    </a>

                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="nav-btn-hover inline-flex rounded-full bg-[#173F8A] px-5 py-3 text-sm font-semibold text-white hover:bg-[#143374]"
                    >
                        Xem danh sách phòng
                    </a>
                </div>
            </article>

            <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
                <div class="reveal-on-scroll reveal-delay-2 news-show-shell-card rounded-[2rem] bg-white p-6">
                    <h3 class="text-xl font-black text-slate-900">Bài viết liên quan</h3>

                    <div class="mt-5 space-y-5">
                        @foreach($relatedPosts as $post)
                            <a href="{{ route('public.news.show', $post['slug']) }}" class="news-related-card block rounded-[1.8rem] bg-slate-50 p-4">
                                <p class="text-sm font-semibold text-[#173F8A]">{{ $post['category'] }}</p>
                                <h4 class="mt-2 text-lg font-black leading-tight text-slate-900">{{ $post['title'] }}</h4>
                                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $post['excerpt'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-3 news-show-shell-card rounded-[2rem] bg-[#081A45] p-6 text-white">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#9ff4ec]">Khám phá thêm</p>
                    <h3 class="mt-3 text-2xl font-black">Tìm phòng phù hợp cho chuyến đi của bạn</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Sau khi đọc cẩm nang, anh có thể quay lại danh sách phòng để chọn hạng phù hợp với nhu cầu lưu trú thực tế.
                    </p>
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="nav-btn-hover mt-6 inline-flex rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#081A45] hover:bg-slate-100"
                    >
                        Xem phòng ngay
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