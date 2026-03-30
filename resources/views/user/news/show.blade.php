<x-layouts.public
    title="{{ $article['title'] }} | Hotel Booking"
    metaDescription="{{ $article['excerpt'] }}"
>
    <section class="relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0">
            <img
                src="{{ $article['image'] }}"
                alt="{{ $article['title'] }}"
                class="h-full w-full object-cover opacity-30"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-sky-950/80"></div>
        </div>

        <div class="relative mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 text-sm text-slate-300">
                <a href="{{ route('home') }}" class="transition hover:text-sky-300">Trang chủ</a>
                <span>/</span>
                <a href="{{ route('public.news.index') }}" class="transition hover:text-sky-300">Tin tức</a>
                <span>/</span>
                <span class="text-white">{{ $article['title'] }}</span>
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-wide text-sky-300">
                <span>{{ $article['category'] }}</span>
                <span>•</span>
                <span>{{ \Carbon\Carbon::parse($article['date'])->format('d/m/Y') }}</span>
                <span>•</span>
                <span>{{ $article['read_time'] }}</span>
            </div>

            <h1 class="mt-5 text-4xl font-black tracking-tight text-white sm:text-5xl">
                {{ $article['title'] }}
            </h1>

            <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">
                {{ $article['excerpt'] }}
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1fr_340px]">
            <article class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="h-[360px] overflow-hidden rounded-[2rem]">
                    <img
                        src="{{ $article['image'] }}"
                        alt="{{ $article['title'] }}"
                        class="h-full w-full object-cover"
                    >
                </div>

                <div class="prose prose-slate mt-8 max-w-none">
                    @foreach($article['content'] as $paragraph)
                        <p class="mb-5 text-base leading-8 text-slate-700">{{ $paragraph }}</p>
                    @endforeach
                </div>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a
                        href="{{ route('public.news.index') }}"
                        class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        ← Quay lại tin tức
                    </a>

                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600"
                    >
                        Xem danh sách phòng
                    </a>
                </div>
            </article>

            <aside class="space-y-6">
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900">Bài viết liên quan</h3>

                    <div class="mt-5 space-y-5">
                        @foreach($relatedPosts as $post)
                            <a href="{{ route('public.news.show', $post['slug']) }}" class="block rounded-3xl border border-slate-200 bg-slate-50 p-4 transition hover:border-sky-300 hover:bg-sky-50">
                                <p class="text-sm font-semibold text-sky-600">{{ $post['category'] }}</p>
                                <h4 class="mt-2 text-lg font-black leading-tight text-slate-900">{{ $post['title'] }}</h4>
                                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $post['excerpt'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-300">Khám phá thêm</p>
                    <h3 class="mt-3 text-2xl font-black">Tìm phòng phù hợp cho chuyến đi của bạn</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Sau khi đọc cẩm nang, bạn có thể quay lại xem danh sách phòng và chọn hạng phù hợp với nhu cầu thực tế.
                    </p>
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="mt-6 inline-flex rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-100"
                    >
                        Xem phòng ngay
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.public>