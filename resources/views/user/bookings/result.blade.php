<x-layouts.public title="Kết quả tra cứu booking">
    @php
        $statusText = match($booking->status) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'checked_in' => 'Đã check-in',
            'checked_out' => 'Đã check-out',
            'cancelled' => 'Đã hủy',
            default => ucfirst($booking->status),
        };

        $statusBadge = match($booking->status) {
            'pending' => 'bg-amber-100 text-amber-700',
            'confirmed' => 'bg-sky-100 text-sky-700',
            'checked_in' => 'bg-emerald-100 text-emerald-700',
            'checked_out' => 'bg-slate-100 text-slate-700',
            'cancelled' => 'bg-rose-100 text-rose-700',
            default => 'bg-slate-100 text-slate-700',
        };

        if ($paidAmount <= 0) {
            $paymentText = 'Chưa thanh toán';
            $paymentBadge = 'bg-rose-100 text-rose-700';
        } elseif ($remainingAmount > 0) {
            $paymentText = 'Đã thanh toán một phần';
            $paymentBadge = 'bg-amber-100 text-amber-700';
        } else {
            $paymentText = 'Đã thanh toán đủ';
            $paymentBadge = 'bg-emerald-100 text-emerald-700';
        }
    @endphp

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">
                    Kết quả tra cứu
                </p>
                <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-slate-900">
                    Booking {{ $bookingCode }}
                </h1>
            </div>

            <div class="flex flex-wrap gap-3">
                <span class="rounded-full px-4 py-2 text-sm font-semibold {{ $statusBadge }}">
                    {{ $statusText }}
                </span>

                <span class="rounded-full px-4 py-2 text-sm font-semibold {{ $paymentBadge }}">
                    {{ $paymentText }}
                </span>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
            <div class="space-y-8">
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="text-2xl font-extrabold text-slate-900">Thông tin booking</h2>

                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs uppercase tracking-wide text-slate-500">Khách hàng</p>
                            <p class="mt-3 text-xl font-bold text-slate-900">{{ $booking->customer?->full_name }}</p>
                            <p class="mt-2 text-sm text-slate-600">
                                {{ $booking->customer?->phone ?: 'Chưa có số điện thoại' }}
                            </p>
                            <p class="mt-1 text-sm text-slate-600">
                                {{ $booking->customer?->email ?: 'Chưa có email' }}
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-xs uppercase tracking-wide text-slate-500">Phòng</p>
                            <p class="mt-3 text-xl font-bold text-slate-900">
                                Phòng {{ $booking->room?->room_number }}
                            </p>
                            <p class="mt-2 text-sm text-slate-600">
                                {{ $booking->room?->roomType?->name }}
                            </p>
                            <p class="mt-1 text-sm text-slate-600">
                                Tầng {{ $booking->room?->floor ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 bg-white p-5">
                            <p class="text-sm text-slate-500">Ngày nhận phòng</p>
                            <p class="mt-2 text-lg font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white p-5">
                            <p class="text-sm text-slate-500">Ngày trả phòng</p>
                            <p class="mt-2 text-lg font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white p-5">
                            <p class="text-sm text-slate-500">Số khách</p>
                            <p class="mt-2 text-lg font-bold text-slate-900">
                                {{ $booking->adults }} người lớn, {{ $booking->children }} trẻ em
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white p-5">
                            <p class="text-sm text-slate-500">Ngày tạo booking</p>
                            <p class="mt-2 text-lg font-bold text-slate-900">
                                {{ $booking->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="text-2xl font-extrabold text-slate-900">Lịch sử thanh toán</h2>

                    @if($booking->payments->isNotEmpty())
                        <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Mã phiếu</th>
                                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Ngày thanh toán</th>
                                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Phương thức</th>
                                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Số tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 bg-white">
                                        @foreach($booking->payments as $payment)
                                            <tr>
                                                <td class="px-5 py-4 text-sm font-semibold text-slate-900">
                                                    #{{ $payment->id }}
                                                </td>
                                                <td class="px-5 py-4 text-sm text-slate-600">
                                                    {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') : 'Chưa cập nhật' }}
                                                </td>
                                                <td class="px-5 py-4 text-sm text-slate-600">
                                                    {{ $payment->payment_method ?? 'N/A' }}
                                                </td>
                                                <td class="px-5 py-4 text-right text-sm font-bold text-slate-900">
                                                    {{ number_format($payment->amount, 0, ',', '.') }} đ
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="mt-6 rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                            Booking này hiện chưa có giao dịch thanh toán nào.
                        </div>
                    @endif
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-extrabold text-slate-900">Tóm tắt thanh toán</h2>

                    <div class="mt-6 space-y-4">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Tổng tiền booking</span>
                            <strong class="text-slate-900">{{ number_format($booking->total_price, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Đã thanh toán</span>
                            <strong class="text-slate-900">{{ number_format($paidAmount, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="border-t border-slate-200 pt-4">
                            <div class="flex items-center justify-between text-base">
                                <span class="font-semibold text-slate-900">Còn lại</span>
                                <strong class="text-lg text-slate-900">{{ number_format($remainingAmount, 0, ',', '.') }} đ</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-sky-200 bg-sky-50 p-6">
                    <h3 class="text-lg font-bold text-sky-900">Mã booking của bạn</h3>
                    <p class="mt-3 text-2xl font-extrabold text-sky-900">{{ $bookingCode }}</p>
                    <p class="mt-3 text-sm leading-6 text-sky-800">
                        Hãy lưu lại mã này để tra cứu booking ở những lần tiếp theo.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a
                        href="{{ route('public.bookings.lookup') }}"
                        class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                    >
                        Tra cứu booking khác
                    </a>

                    <a
                        href="{{ route('home') }}"
                        class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        Về trang chủ
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.public>