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
        ['label' => 'Hỗ trợ', 'value' => 'Thông tin + biểu mẫu thật'],
        ['label' => 'Mục tiêu', 'value' => 'Tin cậy + SEO địa phương'],
        ['label' => 'Trải nghiệm', 'value' => 'Nhanh · Gọn · Liền mạch'],
    ];

    $supportHighlights = [
        [
            'title' => 'Liên hệ nhanh',
            'desc' => 'Cung cấp đầy đủ thông tin để người dùng có thể gọi điện, gửi email hoặc tìm đường dễ dàng hơn.',
        ],
        [
            'title' => 'Biểu mẫu thật',
            'desc' => 'Tin nhắn gửi từ trang liên hệ sẽ được lưu vào hệ thống để bộ phận vận hành tiếp nhận và theo dõi.',
        ],
        [
            'title' => 'Tăng độ tin cậy',
            'desc' => 'Google Map, social links và structured data giúp website đầy đủ hơn cả về trải nghiệm lẫn SEO địa phương.',
        ],
    ];

    $mapEmbedUrl = 'https://www.google.com/maps?q=' . urlencode($contactInfo['map_query']) . '&z=15&output=embed';
@endphp

<x-layouts.public 
    title="Liên hệ | Navara Boutique Hotel"
    metaDescription="Thông tin liên hệ, hỗ trợ cơ bản và giải đáp nhanh cho khách hàng khi sử dụng website Navara Boutique Hotel."
>
    <script type="application/ld+json">
        {!! json_encode($localBusinessSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

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
            0% { opacity: 0; transform: translateY(28px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeLeftSoft {
            0% { opacity: 0; transform: translateX(-28px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeRightSoft {
            0% { opacity: 0; transform: translateX(28px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        @keyframes shineSweep {
            0% { transform: translateX(-130%) skewX(-18deg); opacity: 0; }
            20% { opacity: .22; }
            100% { transform: translateX(220%) skewX(-18deg); opacity: 0; }
        }

        .contact-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .contact-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .contact-input,
        .contact-textarea {
            width: 100%;
            border-radius: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.35);
            background: #fff;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            color: #0f172a;
            transition: .2s ease;
        }

        .contact-textarea {
            min-height: 150px;
            resize: vertical;
        }

        .contact-input:focus,
        .contact-textarea:focus {
            outline: none;
            border-color: rgba(23, 63, 138, 0.7);
            box-shadow: 0 0 0 4px rgba(23, 63, 138, 0.08);
        }

        .contact-label {
            display: block;
            margin-bottom: .55rem;
            font-size: .92rem;
            font-weight: 700;
            color: #334155;
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
                        Trang liên hệ giờ không chỉ là khu vực thông tin cơ bản mà đã có biểu mẫu gửi thật, bản đồ định vị, social links và structured data để hỗ trợ tốt hơn cho cả người dùng lẫn SEO địa phương.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="#contact-form"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Gửi liên hệ ngay
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
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Liên hệ thực tế</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                                    Mọi thông tin hỗ trợ được gom lại rõ ràng và sẵn sàng sử dụng
                                </h2>
                            </div>

                            <div class="rounded-2xl bg-slate-100 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Ưu tiên</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">Nhanh · Rõ · Dễ tiếp cận</p>
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
                            Thông tin hiển thị trên trang và structured data JSON-LD được giữ đồng nhất để tăng độ tin cậy và hỗ trợ máy tìm kiếm hiểu rõ hơn về doanh nghiệp địa phương.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-10 xl:grid-cols-[0.95fr_1.05fr]">
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

                <div class="reveal-on-scroll reveal-delay-2 contact-shell-card overflow-hidden rounded-[2rem] bg-white">
                    <div class="aspect-[16/10] w-full">
                        <iframe
                            src="{{ $mapEmbedUrl }}"
                            class="h-full w-full border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                            title="Bản đồ vị trí {{ $contactInfo['business_name'] }}"
                        ></iframe>
                    </div>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 contact-shell-card rounded-[2rem] bg-white p-6 sm:p-7">
                    <h3 class="text-2xl font-black text-slate-900">Kết nối qua mạng xã hội</h3>
                    <div class="mt-5 grid gap-3">
                        @foreach($socialLinks as $social)
                            <a
                                href="{{ $social['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="nav-btn-hover inline-flex items-center justify-between rounded-[1.2rem] border border-slate-200 bg-slate-50 px-4 py-4 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-white hover:text-[#173F8A]"
                            >
                                <span>{{ $social['label'] }}</span>
                                <span class="text-slate-500">{{ $social['handle'] }}</span>
                            </a>
                        @endforeach
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

            <div class="space-y-6">
                @if(session('contact_success'))
                    <div class="contact-shell-card rounded-[2rem] border border-emerald-200 bg-emerald-50 p-6 text-emerald-800">
                        <p class="text-base font-bold">{{ session('contact_success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="contact-shell-card rounded-[2rem] border border-rose-200 bg-rose-50 p-6 text-rose-700">
                        <p class="text-base font-bold">Vui lòng kiểm tra lại thông tin đã nhập.</p>
                        <ul class="mt-3 list-disc space-y-1.5 pl-5 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="contact-form" class="reveal-on-scroll reveal-delay-1 contact-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <h2 class="text-2xl font-black text-slate-900">Gửi yêu cầu liên hệ</h2>
                    <p class="mt-4 text-sm leading-7 text-slate-600">
                        Anh có thể gửi thắc mắc, nhu cầu hỗ trợ hoặc nội dung cần tư vấn trực tiếp từ biểu mẫu này.
                    </p>

                    <form method="POST" action="{{ route('public.contact.store') }}" class="mt-8 space-y-5">
                        @csrf

                        <div class="grid gap-5 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="contact-label">
                                    Họ và tên <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="full_name"
                                    value="{{ old('full_name') }}"
                                    class="contact-input"
                                    placeholder="Nhập họ và tên của anh"
                                >
                            </div>

                            <div>
                                <label class="contact-label">Số điện thoại</label>
                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    class="contact-input"
                                    placeholder="Nhập số điện thoại"
                                >
                            </div>

                            <div>
                                <label class="contact-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="contact-input"
                                    placeholder="Nhập email"
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label class="contact-label">
                                    Chủ đề <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="subject"
                                    value="{{ old('subject') }}"
                                    class="contact-input"
                                    placeholder="Ví dụ: Tư vấn đặt phòng, hỗ trợ booking, hỏi thông tin..."
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label class="contact-label">
                                    Nội dung liên hệ <span class="text-rose-500">*</span>
                                </label>
                                <textarea
                                    name="message"
                                    class="contact-textarea"
                                    placeholder="Nhập nội dung anh cần hỗ trợ..."
                                >{{ old('message') }}</textarea>
                            </div>
                        </div>

                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                            Anh chỉ cần nhập <strong>họ tên</strong>, <strong>chủ đề</strong>, <strong>nội dung</strong> và ít nhất một cách liên hệ gồm <strong>số điện thoại</strong> hoặc <strong>email</strong>.
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <button
                                type="submit"
                                class="nav-btn-hover inline-flex rounded-full bg-[#173F8A] px-6 py-3 text-sm font-semibold text-white hover:bg-[#143374]"
                            >
                                Gửi liên hệ
                            </button>

                            <a
                                href="{{ route('public.rooms.index') }}"
                                class="nav-btn-hover inline-flex rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100"
                            >
                                Xem phòng nghỉ
                            </a>
                        </div>
                    </form>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 contact-shell-card rounded-[2rem] bg-white p-6 shadow-sm sm:p-8">
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
                        Trang liên hệ hiện đã có đủ các phần cốt lõi cho một website khách sạn thực tế: thông tin liên hệ, form gửi thật, bản đồ nhúng, social links và LocalBusiness/Hotel schema để tăng hiệu quả SEO địa phương.
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