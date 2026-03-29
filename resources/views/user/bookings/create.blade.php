<x-layouts.public title="Đặt phòng">
    @php
        $today = now()->toDateString();
        $displayCheckIn = old('check_in_date', $checkInDate);
        $displayCheckOut = old('check_out_date', $checkOutDate);

        $previewNights = null;
        $previewTotal = null;

        if ($displayCheckIn && $displayCheckOut) {
            try {
                $previewCheckIn = \Carbon\Carbon::parse($displayCheckIn);
                $previewCheckOut = \Carbon\Carbon::parse($displayCheckOut);

                if ($previewCheckOut->gt($previewCheckIn)) {
                    $previewNights = max($previewCheckIn->diffInDays($previewCheckOut), 1);
                    $previewTotal = $previewNights * ($room->roomType->price ?? 0);
                }
            } catch (\Throwable $e) {
                $previewNights = null;
                $previewTotal = null;
            }
        }
    @endphp

    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('home') }}" class="transition hover:text-sky-600">Trang chủ</a>
                <span>/</span>
                <a href="{{ route('public.rooms.index') }}" class="transition hover:text-sky-600">Phòng</a>
                <span>/</span>
                <a href="{{ route('public.rooms.show', ['room' => $room->id, 'check_in_date' => request('check_in_date'), 'check_out_date' => request('check_out_date')]) }}"
                   class="transition hover:text-sky-600">
                    Phòng {{ $room->room_number }}
                </a>
                <span>/</span>
                <span class="text-slate-900">Đặt phòng</span>
            </div>

            <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-900">
                Đặt phòng {{ $room->room_number }}
            </h1>

            <p class="mt-4 max-w-3xl text-lg text-slate-600">
                Điền thông tin bên dưới để gửi yêu cầu đặt phòng. Hệ thống sẽ tự kiểm tra trùng lịch trước khi tạo booking.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
            <aside class="space-y-6">
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <div class="h-52 bg-gradient-to-br from-sky-100 via-cyan-50 to-slate-100"></div>

                    <div class="p-6">
                        <p class="text-sm font-semibold text-sky-600">
                            {{ $room->roomType?->name }}
                        </p>

                        <h2 class="mt-2 text-2xl font-extrabold text-slate-900">
                            Phòng {{ $room->room_number }}
                        </h2>

                        <div class="mt-6 grid grid-cols-2 gap-4 rounded-2xl bg-slate-50 p-4">
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

                        <p class="mt-5 text-sm leading-6 text-slate-600">
                            {{ $room->roomType?->description ?: 'Không gian lưu trú tiện nghi, phù hợp cho nhu cầu nghỉ ngắn ngày và dài ngày.' }}
                        </p>
                    </div>
                </div>

                <div class="rounded-3xl border border-sky-200 bg-sky-50 p-6">
                    <h3 class="text-lg font-bold text-sky-900">Tạm tính</h3>

                    @if($previewNights && $previewTotal)
                        <div class="mt-4 space-y-3 text-sm text-sky-900">
                            <div class="flex items-center justify-between">
                                <span>Số đêm</span>
                                <strong>{{ $previewNights }} đêm</strong>
                            </div>

                            <div class="flex items-center justify-between">
                                <span>Giá mỗi đêm</span>
                                <strong>{{ number_format($room->roomType?->price ?? 0, 0, ',', '.') }} đ</strong>
                            </div>

                            <div class="border-t border-sky-200 pt-3">
                                <div class="flex items-center justify-between text-base">
                                    <span>Tổng tiền dự kiến</span>
                                    <strong>{{ number_format($previewTotal, 0, ',', '.') }} đ</strong>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="mt-3 text-sm leading-6 text-sky-800">
                            Chọn ngày nhận và ngày trả phòng để hệ thống tính tổng tiền tạm tính.
                        </p>
                    @endif
                </div>
            </aside>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-extrabold text-slate-900">Thông tin đặt phòng</h2>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-700">
                        <p class="font-semibold">Vui lòng kiểm tra lại thông tin:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('public.bookings.store', $room) }}" class="mt-8 space-y-8">
                    @csrf

                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Thông tin khách hàng</h3>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Họ và tên <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="full_name"
                                    value="{{ old('full_name') }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    placeholder="Nhập họ và tên"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Số điện thoại
                                </label>
                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    placeholder="Nhập số điện thoại"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Email
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    placeholder="Nhập email"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    CCCD / CMND
                                </label>
                                <input
                                    type="text"
                                    name="identity_number"
                                    value="{{ old('identity_number') }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    placeholder="Nhập CCCD / CMND"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Địa chỉ
                                </label>
                                <input
                                    type="text"
                                    name="address"
                                    value="{{ old('address') }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    placeholder="Nhập địa chỉ"
                                >
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Thông tin lưu trú</h3>

                        <div class="mt-5 grid gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Ngày nhận phòng <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    name="check_in_date"
                                    min="{{ $today }}"
                                    value="{{ old('check_in_date', $checkInDate) }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Ngày trả phòng <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    name="check_out_date"
                                    min="{{ old('check_in_date', $checkInDate ?: $today) }}"
                                    value="{{ old('check_out_date', $checkOutDate) }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Người lớn <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="adults"
                                    min="1"
                                    value="{{ old('adults', 1) }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                >
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Trẻ em
                                </label>
                                <input
                                    type="number"
                                    name="children"
                                    min="0"
                                    value="{{ old('children', 0) }}"
                                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900">
                        Sau khi gửi yêu cầu, booking sẽ được tạo với trạng thái <strong>pending</strong>.
                        Admin có thể xác nhận lại ở phía hệ thống quản trị.
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <button
                            type="submit"
                            class="rounded-2xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600"
                        >
                            Gửi yêu cầu đặt phòng
                        </button>

                        <a
                            href="{{ route('public.rooms.show', ['room' => $room->id, 'check_in_date' => old('check_in_date', $checkInDate), 'check_out_date' => old('check_out_date', $checkOutDate)]) }}"
                            class="rounded-2xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                        >
                            Quay lại chi tiết phòng
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkInInput = document.querySelector('input[name="check_in_date"]');
        const checkOutInput = document.querySelector('input[name="check_out_date"]');
        const fallbackMin = '{{ $today }}';

        if (!checkInInput || !checkOutInput) return;

        function formatDate(date) {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        }

        function syncCheckoutMin() {
            if (!checkInInput.value) {
                checkOutInput.min = fallbackMin;
                return;
            }

            const minCheckout = new Date(checkInInput.value);
            minCheckout.setDate(minCheckout.getDate() + 1);

            const minCheckoutValue = formatDate(minCheckout);
            checkOutInput.min = minCheckoutValue;

            if (!checkOutInput.value || checkOutInput.value <= checkInInput.value) {
                checkOutInput.value = minCheckoutValue;
            }
        }

        syncCheckoutMin();
        checkInInput.addEventListener('change', syncCheckoutMin);
    });
</script>
</x-layouts.public>