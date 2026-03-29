<x-layouts.public>
    <section class="relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-900 to-sky-950"></div>

        <div class="relative mx-auto grid max-w-7xl gap-10 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:items-center lg:px-8 lg:py-24">
            <div>
                <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm font-medium text-white/90">
                    Khách sạn tiện nghi · Đặt phòng nhanh chóng
                </span>

                <h1 class="mt-6 text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl">
                    Trải nghiệm lưu trú
                    <span class="text-sky-300">thoải mái và hiện đại</span>
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                    Khám phá hệ thống phòng nghỉ đa dạng, xem loại phòng hiện có và lựa chọn không gian phù hợp cho chuyến đi của bạn.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="rounded-2xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-900/30 transition hover:bg-sky-600"
                    >
                        Xem phòng ngay
                    </a>

                    <a
                        href="{{ route('public.bookings.lookup') }}"
                        class="rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/20"
                    >
                        Tra cứu booking
                    </a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur">
                    <p class="text-sm text-slate-300">Loại phòng</p>
                    <p class="mt-3 text-4xl font-extrabold text-white">{{ $stats['room_types'] }}</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur">
                    <p class="text-sm text-slate-300">Tổng số phòng</p>
                    <p class="mt-3 text-4xl font-extrabold text-white">{{ $stats['rooms'] }}</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur">
                    <p class="text-sm text-slate-300">Phòng trống hiện tại</p>
                    <p class="mt-3 text-4xl font-extrabold text-white">{{ $stats['available_rooms'] }}</p>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur">
                    <p class="text-sm text-slate-300">Booking đã ghi nhận</p>
                    <p class="mt-3 text-4xl font-extrabold text-white">{{ $stats['bookings'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="room-types" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Loại phòng nổi bật</p>
            <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                Chọn hạng phòng phù hợp với nhu cầu của bạn
            </h2>
            <p class="mt-4 text-slate-600">
                Dưới đây là các loại phòng hiện có trong hệ thống. Bạn có thể xem danh sách phòng, kiểm tra phòng trống theo ngày và gửi yêu cầu đặt phòng ngay trên website.
            </p>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($roomTypes as $roomType)
                <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="h-40 bg-gradient-to-br from-sky-100 via-cyan-50 to-slate-100"></div>

                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">{{ $roomType->name }}</h3>
                                <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-600">
                                    {{ $roomType->description ?: 'Loại phòng tiện nghi, phù hợp cho nhu cầu lưu trú ngắn ngày và dài ngày.' }}
                                </p>
                            </div>

                            <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                {{ $roomType->rooms_count }} phòng
                            </span>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-4 rounded-2xl bg-slate-50 p-4">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-500">Giá / đêm</p>
                                <p class="mt-2 text-lg font-bold text-slate-900">
                                    {{ number_format($roomType->price, 0, ',', '.') }} đ
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-500">Sức chứa</p>
                                <p class="mt-2 text-lg font-bold text-slate-900">
                                    {{ $roomType->capacity }} người
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                    Chưa có loại phòng nào trong hệ thống.
                </div>
            @endforelse
        </div>
    </section>
    <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
    <div class="rounded-[2rem] border border-sky-200 bg-sky-50 p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-700">
                    Đã đặt phòng rồi?
                </p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                    Tra cứu booking nhanh chóng
                </h2>
                <p class="mt-4 max-w-2xl text-slate-600">
                    Nếu bạn đã gửi yêu cầu đặt phòng, hãy dùng mã booking cùng email hoặc số điện thoại để xem lại trạng thái booking và tình trạng thanh toán.
                </p>
            </div>

            <div>
                <a
                    href="{{ route('public.bookings.lookup') }}"
                    class="inline-flex rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    Tra cứu booking
                </a>
            </div>
        </div>
    </div>
</section>
</x-layouts.public>