<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Quản lý thanh toán
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Theo dõi, sắp xếp và phân trang các khoản thanh toán theo từng booking.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Tổng giao dịch theo bộ lọc hiện tại</p>
                    <h3 class="mt-3 text-4xl font-bold text-blue-600">{{ $totalPayments }}</h3>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Tổng tiền đã thu</p>
                    <h3 class="mt-3 text-4xl font-bold text-emerald-600">
                        {{ number_format($totalCollected, 0, ',', '.') }} VNĐ
                    </h3>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('payments.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-6">
                    <div class="xl:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Từ khóa</label>
                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="Tên khách, số phòng, booking ID, ghi chú..."
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Phương thức</label>
                        <select name="payment_method" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tất cả</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                            <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Chuyển khoản</option>
                            <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Thẻ</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Trạng thái</label>
                        <select name="payment_status" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tất cả</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Sắp xếp theo</label>
                        <select name="sort_by" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">
                            <option value="paid_at" {{ request('sort_by', 'paid_at') == 'paid_at' ? 'selected' : '' }}>Thời gian thanh toán</option>
                            <option value="amount" {{ request('sort_by') == 'amount' ? 'selected' : '' }}>Số tiền</option>
                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Thứ tự</label>
                        <select name="sort_dir" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">
                            <option value="desc" {{ request('sort_dir', 'desc') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Mỗi trang</label>
                        <select name="per_page" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">
                            @foreach([10, 20, 50, 100] as $size)
                                <option value="{{ $size }}" {{ (int) request('per_page', 10) === $size ? 'selected' : '' }}>
                                    {{ $size }} dòng
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="xl:col-span-6 flex flex-wrap items-end gap-3">
                        <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">
                            Lọc
                        </button>

                        <a href="{{ route('payments.index') }}" class="rounded-xl bg-slate-200 px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-300">
                            Đặt lại
                        </a>
                    </div>
                </form>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Danh sách thanh toán</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Hiển thị {{ $payments->firstItem() ?? 0 }} - {{ $payments->lastItem() ?? 0 }} / {{ $payments->total() }} giao dịch
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('payments.export-pdf', request()->query()) }}"
                        class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-rose-700">
                            Xuất PDF
                        </a>

                        <a href="{{ route('payments.create') }}"
                        class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                            + Ghi nhận thanh toán
                        </a>
                    </div>
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
                                        <th class="whitespace-nowrap border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Trạng thái</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Thời gian thanh toán</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ghi chú</th>
                                        <th class="whitespace-nowrap border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr class="hover:bg-slate-50">
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $payment->id }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm font-medium text-slate-800">#{{ $payment->booking->id }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $payment->booking->customer->full_name ?? '—' }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $payment->booking->room->room_number ?? '—' }}</td>
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
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm whitespace-nowrap">
                                                @if($payment->payment_status === 'paid')
                                                    <span class="inline-flex whitespace-nowrap rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                                        Đã thanh toán
                                                    </span>
                                                @elseif($payment->payment_status === 'refunded')
                                                    <span class="inline-flex whitespace-nowrap rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">
                                                        Hoàn tiền
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">
                                                {{ optional($payment->paid_at)->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">
                                                {{ $payment->note ?: '—' }}
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm whitespace-nowrap">
                                                @if (Route::has('bookings.show'))
                                                    <a href="{{ route('bookings.show', $payment->booking->id) }}"
                                                    class="inline-flex items-center whitespace-nowrap rounded-lg bg-slate-700 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800">
                                                        Xem phiếu
                                                    </a>
                                                @else
                                                    <span class="text-slate-400">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <p class="text-sm text-slate-500">
                                Đang hiển thị {{ $payments->firstItem() ?? 0 }} - {{ $payments->lastItem() ?? 0 }} trong tổng {{ $payments->total() }} giao dịch
                            </p>

                            <div>
                                {{ $payments->links() }}
                            </div>
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