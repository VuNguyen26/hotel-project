<x-layouts.public title="Đặt phòng thành công">
    @php
        $statusText = match($summary['status']) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'checked_in' => 'Đã check-in',
            'checked_out' => 'Đã check-out',
            'cancelled' => 'Đã hủy',
            default => ucfirst($summary['status']),
        };
    @endphp

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-[2rem] border border-emerald-200 bg-white shadow-sm">
            <div class="border-b border-emerald-200 bg-emerald-50 px-6 py-8 sm:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-700">
                            Đặt phòng thành công
                        </p>
                        <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                            Yêu cầu đặt phòng của bạn đã được ghi nhận
                        </h1>
                    </div>

                    <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                        {{ $statusText }}
                    </span>
                </div>

                <p class="mt-4 text-slate-600">
                    Vui lòng lưu lại mã booking bên dưới để tiện đối chiếu khi cần.
                </p>
            </div>

            <div class="px-6 py-8 sm:px-8">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Mã booking</p>
                        <p class="mt-3 text-2xl font-extrabold text-slate-900">
                            {{ $summary['booking_code'] }}
                        </p>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Tổng tiền dự kiến</p>
                        <p class="mt-3 text-2xl font-extrabold text-slate-900">
                            {{ number_format($summary['total_price'], 0, ',', '.') }} đ
                        </p>
                    </div>
                </div>

                <div class="mt-8 grid gap-8 md:grid-cols-2">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Thông tin khách hàng</h2>

                        <div class="mt-4 space-y-3 text-sm text-slate-700">
                            <div>
                                <span class="text-slate-500">Họ tên:</span>
                                <strong>{{ $summary['customer_name'] }}</strong>
                            </div>

                            <div>
                                <span class="text-slate-500">Số điện thoại:</span>
                                <strong>{{ $summary['customer_phone'] ?: 'Chưa cung cấp' }}</strong>
                            </div>

                            <div>
                                <span class="text-slate-500">Email:</span>
                                <strong>{{ $summary['customer_email'] ?: 'Chưa cung cấp' }}</strong>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Thông tin lưu trú</h2>

                        <div class="mt-4 space-y-3 text-sm text-slate-700">
                            <div>
                                <span class="text-slate-500">Phòng:</span>
                                <strong>{{ $summary['room_number'] }} - {{ $summary['room_type'] }}</strong>
                            </div>

                            <div>
                                <span class="text-slate-500">Ngày nhận phòng:</span>
                                <strong>{{ \Carbon\Carbon::parse($summary['check_in_date'])->format('d/m/Y') }}</strong>
                            </div>

                            <div>
                                <span class="text-slate-500">Ngày trả phòng:</span>
                                <strong>{{ \Carbon\Carbon::parse($summary['check_out_date'])->format('d/m/Y') }}</strong>
                            </div>

                            <div>
                                <span class="text-slate-500">Số đêm:</span>
                                <strong>{{ $summary['nights'] }} đêm</strong>
                            </div>

                            <div>
                                <span class="text-slate-500">Số khách:</span>
                                <strong>{{ $summary['adults'] }} người lớn, {{ $summary['children'] }} trẻ em</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 rounded-3xl border border-sky-200 bg-sky-50 p-5 text-sm leading-7 text-sky-900">
                    Booking của bạn hiện đang ở trạng thái <strong>{{ $statusText }}</strong>.
                    Ở bước tiếp theo mình có thể làm thêm trang <strong>tra cứu booking</strong> để người dùng nhập mã và xem lại thông tin bất cứ lúc nào.
                </div>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a
                        href="{{ route('home') }}"
                        class="rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                    >
                        Về trang chủ
                    </a>

                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="rounded-2xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        Xem thêm phòng khác
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>