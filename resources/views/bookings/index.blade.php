<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Danh sách đặt phòng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Tìm kiếm booking theo tên khách, số phòng, trạng thái và thanh toán.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('bookings.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
                    <div class="xl:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Từ khóa</label>
                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="Tên khách hoặc số phòng"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Trạng thái booking</label>
                        <select
                            name="status"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Tất cả</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Đã nhận phòng</option>
                            <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Đã trả phòng</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Thanh toán</label>
                        <select
                            name="payment_filter"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Tất cả</option>
                            <option value="unpaid" {{ request('payment_filter') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                            <option value="partial" {{ request('payment_filter') == 'partial' ? 'selected' : '' }}>Thanh toán một phần</option>
                            <option value="paid" {{ request('payment_filter') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-3">
                        <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">
                            Lọc
                        </button>

                        <a href="{{ route('bookings.index') }}" class="rounded-xl bg-slate-200 px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-300">
                            Đặt lại
                        </a>
                    </div>
                </form>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Các đặt phòng hiện có</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Kết quả tìm thấy: {{ $bookings->count() }} booking
                        </p>
                    </div>

                    <a href="{{ route('bookings.create') }}"
                       class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                        + Tạo đặt phòng
                    </a>
                </div>

                <div class="px-6 py-6">
                    @if($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-slate-50">
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">ID</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Khách hàng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Phòng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Loại phòng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ngày nhận</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ngày trả</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Người lớn</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Trẻ em</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Tổng tiền</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Thanh toán</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Trạng thái</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ngày tạo</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-700">Nghiệp vụ nhanh</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-700">Khác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        @php
                                            $paidAmount = $booking->payments->where('payment_status', 'paid')->sum('amount');
                                            $remainingAmount = max($booking->total_price - $paidAmount, 0);
                                        @endphp

                                        <tr class="hover:bg-slate-50">
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $booking->id }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm font-medium text-slate-800">{{ $booking->customer->full_name }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $booking->room->room_number }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $booking->room->roomType->name }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $booking->adults }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $booking->children }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm font-semibold text-slate-800">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</td>

                                            <td class="border-b border-slate-100 px-4 py-4 text-sm table-badge-cell">
                                                @if($paidAmount >= $booking->total_price && $booking->total_price > 0)
                                                    <span class="badge badge-green">
                                                        Đã thanh toán
                                                    </span>
                                                @elseif($paidAmount > 0)
                                                    <div class="flex flex-col gap-1">
                                                        <span class="badge badge-amber w-fit">
                                                            Một phần
                                                        </span>
                                                        <span class="text-xs text-slate-500 whitespace-nowrap">
                                                            Còn {{ number_format($remainingAmount, 0, ',', '.') }} VNĐ
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="badge badge-rose">
                                                        Chưa thanh toán
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="border-b border-slate-100 px-4 py-4 text-sm table-badge-cell">
                                                @if($booking->status === 'pending')
                                                    <span class="badge badge-amber">Chờ xác nhận</span>
                                                @elseif($booking->status === 'confirmed')
                                                    <span class="badge badge-blue">Đã xác nhận</span>
                                                @elseif($booking->status === 'checked_in')
                                                    <span class="badge badge-green">Đã nhận phòng</span>
                                                @elseif($booking->status === 'checked_out')
                                                    <span class="badge badge-slate">Đã trả phòng</span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="badge badge-rose">Đã hủy</span>
                                                @endif
                                            </td>

                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $booking->created_at->format('d/m/Y H:i') }}</td>

                                            <td class="border-b border-slate-100 px-4 py-4 align-top">
                                                <div class="action-stack">
                                                    @if($booking->status === 'pending')
                                                        <form action="{{ route('bookings.update-status', $booking->id) }}" method="POST" class="action-form">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit" class="action-btn-sm bg-blue-600 hover:bg-blue-700">
                                                                Xác nhận
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('bookings.update-status', $booking->id) }}" method="POST" class="action-form">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit" class="action-btn-sm bg-rose-600 hover:bg-rose-700">
                                                                Hủy
                                                            </button>
                                                        </form>

                                                    @elseif($booking->status === 'confirmed')
                                                        <form action="{{ route('bookings.update-status', $booking->id) }}" method="POST" class="action-form">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="checked_in">
                                                            <button type="submit" class="action-btn-sm bg-emerald-600 hover:bg-emerald-700">
                                                                Check-in
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('bookings.update-status', $booking->id) }}" method="POST" class="action-form">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit" class="action-btn-sm bg-rose-600 hover:bg-rose-700">
                                                                Hủy
                                                            </button>
                                                        </form>

                                                    @elseif($booking->status === 'checked_in')
                                                        <form action="{{ route('bookings.update-status', $booking->id) }}" method="POST" class="action-form">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="checked_out">
                                                            <button type="submit" class="action-btn-sm bg-slate-700 hover:bg-slate-800">
                                                                Check-out
                                                            </button>
                                                        </form>

                                                    @else
                                                        <span class="text-xs text-slate-400">Không có</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="border-b border-slate-100 px-4 py-4 align-top">
                                                <div class="action-stack">
                                                    @if($booking->status !== 'cancelled' && $remainingAmount > 0)
                                                        <a href="{{ route('payments.create', ['booking' => $booking->id]) }}"
                                                            class="action-btn-sm bg-violet-600 hover:bg-violet-700">
                                                            Thanh toán
                                                        </a>
                                                    @endif

                                                   <a href="{{ route('bookings.edit', $booking->id) }}"
                                                        class="action-btn-sm bg-amber-500 hover:bg-amber-600">
                                                        Sửa
                                                    </a>

                                                    <form action="{{ route('bookings.destroy', $booking->id) }}"
                                                        method="POST"
                                                        class="action-form"
                                                        onsubmit="return confirm('Bạn có chắc muốn xóa đặt phòng này không?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="w-full rounded-lg bg-rose-600 px-3 py-2 text-center text-xs font-semibold leading-none text-white hover:bg-rose-700">
                                                            Xóa
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-300 px-6 py-10 text-center text-slate-500">
                            Không tìm thấy booking nào phù hợp.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>