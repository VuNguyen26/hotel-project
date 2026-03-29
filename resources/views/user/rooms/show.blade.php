<x-layouts.public title="Chi tiết phòng">
    @php
        $badgeClasses = match($room->status) {
            'available' => 'bg-emerald-100 text-emerald-700',
            'booked' => 'bg-amber-100 text-amber-700',
            'occupied' => 'bg-rose-100 text-rose-700',
            default => 'bg-slate-100 text-slate-700',
        };

        $statusText = match($room->status) {
            'available' => 'Còn trống',
            'booked' => 'Đã được đặt',
            'occupied' => 'Đang sử dụng',
            default => ucfirst($room->status),
        };
    @endphp

    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('home') }}" class="transition hover:text-sky-600">Trang chủ</a>
                <span>/</span>
                <a href="{{ route('public.rooms.index') }}" class="transition hover:text-sky-600">Phòng</a>
                <span>/</span>
                <span class="text-slate-900">Phòng {{ $room->room_number }}</span>
            </div>

            <div class="mt-6 grid gap-10 lg:grid-cols-[1.15fr_0.85fr] lg:items-start">
                <div>
                    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                        <div class="h-[380px] bg-gradient-to-br from-sky-100 via-cyan-50 to-slate-100"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">
                                {{ $room->roomType?->name }}
                            </p>
                            <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-slate-900">
                                Phòng {{ $room->room_number }}
                            </h1>
                        </div>

                        <span class="rounded-full px-4 py-2 text-sm font-semibold {{ $badgeClasses }}">
                            {{ $statusText }}
                        </span>
                    </div>

                    <p class="mt-5 text-lg leading-8 text-slate-600">
                        {{ $room->roomType?->description ?: 'Không gian lưu trú tiện nghi, phù hợp cho nhu cầu nghỉ dưỡng, công tác hoặc lưu trú ngắn ngày.' }}
                    </p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs uppercase tracking-wide text-slate-500">Giá / đêm</p>
                            <p class="mt-3 text-2xl font-extrabold text-slate-900">
                                {{ number_format($room->roomType?->price ?? 0, 0, ',', '.') }} đ
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs uppercase tracking-wide text-slate-500">Sức chứa</p>
                            <p class="mt-3 text-2xl font-extrabold text-slate-900">
                                {{ $room->roomType?->capacity ?? 0 }} người
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs uppercase tracking-wide text-slate-500">Tầng</p>
                            <p class="mt-3 text-xl font-bold text-slate-900">
                                {{ $room->floor ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs uppercase tracking-wide text-slate-500">Loại phòng</p>
                            <p class="mt-3 text-xl font-bold text-slate-900">
                                {{ $room->roomType?->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-bold text-slate-900">Thông tin thêm</h2>

                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                            <div>
                                <p class="text-sm text-slate-500">Mã phòng</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">#{{ $room->id }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Trạng thái hiện tại</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">{{ $statusText }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Giá niêm yết</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">
                                    {{ number_format($room->roomType?->price ?? 0, 0, ',', '.') }} đ / đêm
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Sức chứa phù hợp</p>
                                <p class="mt-1 text-base font-semibold text-slate-900">
                                    {{ $room->roomType?->capacity ?? 0 }} người
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a
                            href="{{ route('public.bookings.create', [
                                'room' => $room->id,
                                'check_in_date' => request('check_in_date'),
                                'check_out_date' => request('check_out_date'),
                            ]) }}"
                            class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600"
                        >
                            Đặt phòng ngay
                        </a>

                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                        >
                            ← Quay lại danh sách phòng
                        </a>

                        <a
                            href="{{ route('home') }}"
                            class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                        >
                            Về trang chủ
                        </a>
                    </div>

                    <div class="mt-6 rounded-3xl border border-sky-200 bg-sky-50 p-5 text-sm leading-7 text-sky-900">
                        Bước tiếp theo mình sẽ làm chức năng tìm phòng trống theo ngày và form đặt phòng phía user,
                        để người dùng có thể kiểm tra chính xác phòng còn trống trong khoảng thời gian mong muốn.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">
                    Gợi ý thêm
                </p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                    Một số phòng cùng loại
                </h2>
            </div>

            <a
                href="{{ route('public.rooms.index') }}"
                class="hidden rounded-2xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 sm:inline-flex"
            >
                Xem tất cả phòng
            </a>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($relatedRooms as $relatedRoom)
                @php
                    $relatedBadgeClasses = match($relatedRoom->status) {
                        'available' => 'bg-emerald-100 text-emerald-700',
                        'booked' => 'bg-amber-100 text-amber-700',
                        'occupied' => 'bg-rose-100 text-rose-700',
                        default => 'bg-slate-100 text-slate-700',
                    };

                    $relatedStatusText = match($relatedRoom->status) {
                        'available' => 'Còn trống',
                        'booked' => 'Đã được đặt',
                        'occupied' => 'Đang sử dụng',
                        default => ucfirst($relatedRoom->status),
                    };
                @endphp

                <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="h-44 bg-gradient-to-br from-sky-100 via-cyan-50 to-slate-100"></div>

                    <div class="p-6">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-sky-600">
                                    {{ $relatedRoom->roomType?->name }}
                                </p>
                                <h3 class="mt-1 text-xl font-extrabold text-slate-900">
                                    Phòng {{ $relatedRoom->room_number }}
                                </h3>
                            </div>

                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $relatedBadgeClasses }}">
                                {{ $relatedStatusText }}
                            </span>
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-4 rounded-2xl bg-slate-50 p-4">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-500">Giá / đêm</p>
                                <p class="mt-2 text-lg font-bold text-slate-900">
                                    {{ number_format($relatedRoom->roomType?->price ?? 0, 0, ',', '.') }} đ
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-500">Sức chứa</p>
                                <p class="mt-2 text-lg font-bold text-slate-900">
                                    {{ $relatedRoom->roomType?->capacity ?? 0 }} người
                                </p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a
                                href="{{ route('public.rooms.show', $relatedRoom) }}"
                                class="inline-flex rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800"
                            >
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                    Hiện chưa có thêm phòng cùng loại để hiển thị.
                </div>
            @endforelse
        </div>
    </section>
</x-layouts.public>