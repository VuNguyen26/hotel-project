<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Quản lý thanh toán
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Theo dõi các khoản thanh toán theo từng booking.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Tổng giao dịch</p>
                    <h3 class="mt-3 text-4xl font-bold text-blue-600">{{ $payments->count() }}</h3>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Tổng tiền đã thu</p>
                    <h3 class="mt-3 text-4xl font-bold text-emerald-600">
                        {{ number_format($totalCollected, 0, ',', '.') }} VNĐ
                    </h3>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Danh sách thanh toán</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Các khoản tiền đã ghi nhận trong hệ thống.
                        </p>
                    </div>

                    <a href="{{ route('payments.create') }}"
                       class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                        + Ghi nhận thanh toán
                    </a>
                </div>

                <div class="px-6 py-6">
                    @if(session('success'))
                        <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($payments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-slate-50">
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">ID</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Booking</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Khách hàng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Phòng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Số tiền</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Phương thức</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Trạng thái</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Thời gian thanh toán</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr class="hover:bg-slate-50">
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $payment->id }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm font-medium text-slate-800">#{{ $payment->booking->id }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $payment->booking->customer->full_name ?? '' }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $payment->booking->room->room_number ?? '' }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm font-semibold text-slate-800">
                                                {{ number_format($payment->amount, 0, ',', '.') }} VNĐ
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">
                                                @if($payment->payment_method === 'cash')
                                                    Tiền mặt
                                                @elseif($payment->payment_method === 'transfer')
                                                    Chuyển khoản
                                                @elseif($payment->payment_method === 'card')
                                                    Thẻ
                                                @endif
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm">
                                                @if($payment->payment_status === 'paid')
                                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                        Đã thanh toán
                                                    </span>
                                                @elseif($payment->payment_status === 'refunded')
                                                    <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                                        Hoàn tiền
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">
                                                {{ optional($payment->paid_at)->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">
                                                {{ $payment->note }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-300 px-6 py-10 text-center text-slate-500">
                            Chưa có giao dịch thanh toán nào.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>