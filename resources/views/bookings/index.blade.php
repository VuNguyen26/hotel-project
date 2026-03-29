<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Danh sách đặt phòng
            </h2>

            <a href="{{ route('bookings.create') }}"
               class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                + Tạo đặt phòng
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Các đặt phòng hiện có</h3>

                @if($bookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">ID</th>
                                    <th class="border px-4 py-2 text-left">Khách hàng</th>
                                    <th class="border px-4 py-2 text-left">Phòng</th>
                                    <th class="border px-4 py-2 text-left">Loại phòng</th>
                                    <th class="border px-4 py-2 text-left">Ngày nhận</th>
                                    <th class="border px-4 py-2 text-left">Ngày trả</th>
                                    <th class="border px-4 py-2 text-left">Người lớn</th>
                                    <th class="border px-4 py-2 text-left">Trẻ em</th>
                                    <th class="border px-4 py-2 text-left">Tổng tiền</th>
                                    <th class="border px-4 py-2 text-left">Trạng thái</th>
                                    <th class="border px-4 py-2 text-left">Ngày tạo</th>
                                    <th class="border px-4 py-2 text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $booking->id }}</td>
                                        <td class="border px-4 py-2">{{ $booking->customer->full_name }}</td>
                                        <td class="border px-4 py-2">{{ $booking->room->room_number }}</td>
                                        <td class="border px-4 py-2">{{ $booking->room->roomType->name }}</td>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</td>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</td>
                                        <td class="border px-4 py-2">{{ $booking->adults }}</td>
                                        <td class="border px-4 py-2">{{ $booking->children }}</td>
                                        <td class="border px-4 py-2">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</td>
                                        <td class="border px-4 py-2">
                                            @if($booking->status === 'pending')
                                                Chờ xác nhận
                                            @elseif($booking->status === 'confirmed')
                                                Đã xác nhận
                                            @elseif($booking->status === 'checked_in')
                                                Đã nhận phòng
                                            @elseif($booking->status === 'checked_out')
                                                Đã trả phòng
                                            @elseif($booking->status === 'cancelled')
                                                Đã hủy
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="border px-4 py-2">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('bookings.edit', $booking->id) }}"
                                                   class="rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600">
                                                    Sửa
                                                </a>

                                                <form action="{{ route('bookings.destroy', $booking->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa đặt phòng này không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="rounded bg-red-600 px-3 py-1 text-white hover:bg-red-700">
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
                    <p class="text-gray-500">Chưa có đặt phòng nào.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>