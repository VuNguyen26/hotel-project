<x-layouts.public
    title="Tin tức & Cẩm nang | Hotel Booking"
    metaDescription="Khám phá các bài viết về kinh nghiệm đặt phòng, lưu trú, cẩm nang du lịch và hướng dẫn sử dụng website Hotel Booking."
>
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Tin tức & cẩm nang</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">
                Nội dung hữu ích để website giàu thông tin hơn và hỗ trợ SEO tốt hơn
            </h1>
            <p class="mt-5 max-w-3xl text-lg leading-8 text-slate-600">
                Các bài viết dưới đây giúp người dùng hiểu rõ hơn về cách chọn phòng, thời điểm đặt phòng, trải nghiệm lưu trú và các lưu ý trước khi đặt.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            @foreach($newsItems as $article)
                <article class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="h-60 overflow-hidden">
                        <img
                            src="{{ $article['image'] }}"
                            alt="{{ $article['title'] }}"
                            class="h-full w-full object-cover transition duration-500 hover:scale-105"
                            loading="lazy"
                        >
                    </div>

                    <div class="p-6">
                        <div class="flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <span>{{ $article['category'] }}</span>
                            <span>•</span>
                            <span>{{ \Carbon\Carbon::parse($article['date'])->format('d/m/Y') }}</span>
                            <span>•</span>
                            <span>{{ $article['read_time'] }}</span>
                        </div>

                        <h2 class="mt-4 text-2xl font-black leading-tight text-slate-900">
                            {{ $article['title'] }}
                        </h2>

                        <p class="mt-4 text-sm leading-7 text-slate-600">
                            {{ $article['excerpt'] }}
                        </p>

                        <a
                            href="{{ route('public.news.show', $article['slug']) }}"
                            class="mt-6 inline-flex rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800"
                        >
                            Đọc chi tiết
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</x-layouts.public>