<x-layouts.public title="Danh sách phòng">
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">
                Danh sách phòng
            </p>

            <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-slate-900">
                Tìm phòng trống theo ngày
            </h1>

            <p class="mt-4 max-w-3xl text-lg text-slate-600">
                Chọn khoảng thời gian lưu trú để hệ thống lọc ra các phòng không bị trùng lịch booking.
                Đây là bước quan trọng trước khi làm form đặt phòng phía user.
            </p>

            @if($hasDateSearch)
                <div class="mt-6 rounded-3xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-800">
                    <p class="text-sm font-semibold uppercase tracking-wide">
                        Kết quả tìm phòng trống
                    </p>
                    <p class="mt-2 text-base font-medium">
                        Từ ngày <strong>{{ \Carbon\Carbon::parse($checkInDate)->format('d/m/Y') }}</strong>
                        đến ngày <strong>{{ \Carbon\Carbon::parse($checkOutDate)->format('d/m/Y') }}</strong>
                    </p>
                </div>
            @endif

            @if($dateSearchError)
                <div class="mt-6 rounded-3xl border border-rose-200 bg-rose-50 p-5 text-rose-700">
                    {{ $dateSearchError }}
                </div>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[320px_minmax(0,1fr)]">
            <aside>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900">Tìm kiếm & bộ lọc</h2>

                    <form method="GET" action="{{ route('public.rooms.index') }}" class="mt-6 space-y-5">
                        <div class="rounded-2xl border border-sky-200 bg-sky-50 p-4">
                            <p class="text-sm font-semibold text-sky-800">
                                Tìm phòng trống theo ngày
                            </p>
                            <p class="mt-1 text-xs leading-5 text-sky-700">
                                Hệ thống sẽ loại các phòng có booking bị trùng trong khoảng ngày bạn chọn.
                            </p>

                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Ngày nhận phòng
                                    </label>
                                    <input
                                        type="date"
                                        name="check_in_date"
                                        value="{{ request('check_in_date') }}"
                                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    >
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Ngày trả phòng
                                    </label>
                                    <input
                                        type="date"
                                        name="check_out_date"
                                        value="{{ request('check_out_date') }}"
                                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    >
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Loại phòng
                            </label>
                            <select
                                name="room_type_id"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                            >
                                <option value="">Tất cả loại phòng</option>
                                @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}" @selected(request('room_type_id') == $roomType->id)>
                                        {{ $roomType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Sức chứa tối thiểu
                            </label>
                            <select
                                name="capacity"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                            >
                                <option value="">Không giới hạn</option>
                                <option value="1" @selected(request('capacity') == '1')>Từ 1 người</option>
                                <option value="2" @selected(request('capacity') == '2')>Từ 2 người</option>
                                <option value="3" @selected(request('capacity') == '3')>Từ 3 người</option>
                                <option value="4" @selected(request('capacity') == '4')>Từ 4 người</option>
                                <option value="5" @selected(request('capacity') == '5')>Từ 5 người</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Trạng thái hiện tại
                            </label>
                            <select
                                name="status"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                            >
                                <option value="">Tất cả trạng thái</option>
                                <option value="available" @selected(request('status') == 'available')>Còn trống</option>
                                <option value="booked" @selected(request('status') == 'booked')>Đã được đặt</option>
                                <option value="occupied" @selected(request('status') == 'occupied')>Đang sử dụng</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Sắp xếp
                            </label>
                            <select
                                name="sort"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                            >
                                <option value="latest" @selected(request('sort', 'latest') == 'latest')>Mới nhất</option>
                                <option value="price_asc" @selected(request('sort') == 'price_asc')>Giá tăng dần</option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>Giá giảm dần</option>
                                <option value="room_number_asc" @selected(request('sort') == 'room_number_asc')>Số phòng tăng dần</option>
                                <option value="room_number_desc" @selected(request('sort') == 'room_number_desc')>Số phòng giảm dần</option>
                            </select>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button
                                type="submit"
                                class="flex-1 rounded-2xl bg-sky-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-600"
                            >
                                Tìm phòng
                            </button>

                            <a
                                href="{{ route('public.rooms.index') }}"
                                class="rounded-2xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                            >
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            <div>
                <div class="mb-6 flex flex-col gap-3 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            Kết quả tìm thấy: {{ $rooms->total() }} phòng
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Đang hiển thị từ {{ $rooms->firstItem() ?? 0 }} đến {{ $rooms->lastItem() ?? 0 }}
                        </p>
                    </div>

                    <a
                        href="{{ route('home') }}"
                        class="inline-flex rounded-2xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        ← Về trang chủ
                    </a>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @forelse($rooms as $room)
                        @php
                            if ($hasDateSearch) {
                                $badgeClasses = 'bg-emerald-100 text-emerald-700';
                                $statusText = 'Trống theo ngày đã chọn';
                            } else {
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
                            }

                            $detailParams = ['room' => $room->id];

                            if (request('check_in_date')) {
                                $detailParams['check_in_date'] = request('check_in_date');
                            }

                            if (request('check_out_date')) {
                                $detailParams['check_out_date'] = request('check_out_date');
                            }
                        @endphp

                        <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="h-44 bg-gradient-to-br from-sky-100 via-cyan-50 to-slate-100"></div>

                            <div class="p-6">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-sky-600">
                                            {{ $room->roomType?->name }}
                                        </p>
                                        <h3 class="mt-1 text-xl font-extrabold text-slate-900">
                                            Phòng {{ $room->room_number }}
                                        </h3>
                                    </div>

                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                        {{ $statusText }}
                                    </span>
                                </div>

                                <div class="mt-5 grid grid-cols-2 gap-4 rounded-2xl bg-slate-50 p-4">
                                    <div>
                                        <p class="text-xs uppercase tracking-wide text-slate-500">Giá / đêm</p>
                                        <p class="mt-2 text-lg font-bold text-slate-900">
                                            {{ number_format($room->roomType?->price ?? 0, 0, ',', '.') }} đ
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs uppercase tracking-wide text-slate-500">Sức chứa</p>
                                        <p class="mt-2 text-lg font-bold text-slate-900">
                                            {{ $room->roomType?->capacity ?? 0 }} người
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs uppercase tracking-wide text-slate-500">Tầng</p>
                                        <p class="mt-2 text-base font-semibold text-slate-900">
                                            {{ $room->floor ?? 'N/A' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs uppercase tracking-wide text-slate-500">Loại phòng</p>
                                        <p class="mt-2 text-base font-semibold text-slate-900">
                                            {{ $room->roomType?->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <p class="text-sm leading-6 text-slate-600">
                                        {{ $room->roomType?->description ?: 'Không gian lưu trú tiện nghi, phù hợp cho nhu cầu nghỉ ngắn ngày và dài ngày.' }}
                                    </p>
                                </div>

                                <div class="mt-6 flex items-center justify-between gap-3">
                                    <span class="text-sm text-slate-500">
                                        Mã phòng: #{{ $room->id }}
                                    </span>

                                    <div class="flex gap-2">
                                        <a
                                            href="{{ route('public.rooms.show', $detailParams) }}"
                                            class="rounded-2xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                                        >
                                            Chi tiết
                                        </a>

                                        <a
                                            href="{{ route('public.bookings.create', [
                                                'room' => $room->id,
                                                'check_in_date' => request('check_in_date'),
                                                'check_out_date' => request('check_out_date'),
                                            ]) }}"
                                            class="rounded-2xl bg-sky-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-600"
                                        >
                                            Đặt ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                            Không có phòng nào phù hợp với bộ lọc hiện tại.
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $rooms->links() }}
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>