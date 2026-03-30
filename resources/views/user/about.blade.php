<x-layouts.public
    title="Giới thiệu | Hotel Booking"
    metaDescription="Tìm hiểu về Hotel Booking, định hướng trải nghiệm đặt phòng, tiện ích lưu trú và những giá trị nổi bật của website khách sạn."
>
    <section class="relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80"
                alt="Giới thiệu khách sạn"
                class="h-full w-full object-cover opacity-30"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-sky-950/80"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-4xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-300">Giới thiệu</p>
                <h1 class="mt-4 text-4xl font-black tracking-tight text-white sm:text-5xl">
                    Một website đặt phòng khách sạn theo hướng hiện đại, rõ ràng và dễ sử dụng
                </h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-300">
                    Hotel Booking được xây dựng để giúp người dùng dễ dàng khám phá hạng phòng, kiểm tra phòng trống theo ngày, gửi yêu cầu đặt phòng và tra cứu lại booking sau khi đặt.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1fr_0.95fr] lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Tầm nhìn trải nghiệm</p>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                    Tập trung vào luồng đặt phòng trực quan và dễ theo dõi
                </h2>
                <div class="mt-6 space-y-5 text-base leading-8 text-slate-600">
                    <p>
                        Website user side được thiết kế theo tinh thần của các nền tảng đặt phòng hiện đại: nội dung rõ ràng, hình ảnh nhiều hơn, thông tin phòng chi tiết hơn và có các khối nội dung hỗ trợ SEO như giới thiệu, FAQ, tin tức và liên hệ.
                    </p>
                    <p>
                        Không chỉ dừng ở giao diện, hệ thống còn bám vào nghiệp vụ thật của hotel admin: chống trùng lịch booking, quản lý trạng thái phòng, theo dõi thanh toán và cho phép người dùng tra cứu booking sau khi gửi yêu cầu đặt phòng.
                    </p>
                    <p>
                        Điều này giúp website vừa phù hợp để demo, vừa có thể phát triển tiếp theo hướng website khách sạn thực tế trong tương lai.
                    </p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @foreach($milestones as $item)
                    <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                        <p class="text-3xl font-black text-slate-900">{{ $item['number'] }}</p>
                        <p class="mt-3 text-sm font-semibold text-slate-600">{{ $item['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Điểm nổi bật</p>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                    Những giá trị chính của hệ thống
                </h2>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach($features as $feature)
                    <article class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                        <h3 class="text-xl font-black text-slate-900">{{ $feature['title'] }}</h3>
                        <p class="mt-4 text-sm leading-7 text-slate-600">{{ $feature['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-[2.5rem] bg-slate-950 px-8 py-12 text-white">
            <div class="grid gap-8 lg:grid-cols-[1fr_0.8fr] lg:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-300">Khám phá thêm</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight">
                        Xem phòng, đọc tin tức hoặc tra cứu booking ngay trên website
                    </h2>
                    <p class="mt-4 max-w-2xl text-slate-300">
                        Sau khi đã có nội dung giới thiệu, website trở nên đầy đủ hơn về trải nghiệm khám phá lẫn nền tảng SEO on-page.
                    </p>
                </div>

                <div class="flex flex-wrap gap-4 lg:justify-end">
                    <a href="{{ route('public.rooms.index') }}" class="rounded-2xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">
                        Xem danh sách phòng
                    </a>
                    <a href="{{ route('public.news.index') }}" class="rounded-2xl border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/20">
                        Đọc tin tức
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>