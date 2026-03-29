<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Danh sách phòng
            </h2>

            <a href="{{ route('rooms.create') }}"
               class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                + Thêm phòng
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
                <h3 class="text-lg font-bold mb-4">Các phòng hiện có</h3>

                @if($rooms->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">ID</th>
                                    <th class="border px-4 py-2 text-left">Số phòng</th>
                                    <th class="border px-4 py-2 text-left">Loại phòng</th>
                                    <th class="border px-4 py-2 text-left">Tầng</th>
                                    <th class="border px-4 py-2 text-left">Trạng thái</th>
                                    <th class="border px-4 py-2 text-left">Ghi chú</th>
                                    <th class="border px-4 py-2 text-left">Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $room->id }}</td>
                                        <td class="border px-4 py-2">{{ $room->room_number }}</td>
                                        <td class="border px-4 py-2">{{ $room->roomType->name }}</td>
                                        <td class="border px-4 py-2">{{ $room->floor }}</td>
                                        <td class="border px-4 py-2">
                                            @if($room->status === 'available')
                                                Còn trống
                                            @elseif($room->status === 'booked')
                                                Đã đặt
                                            @elseif($room->status === 'occupied')
                                                Đang sử dụng
                                            @elseif($room->status === 'maintenance')
                                                Bảo trì
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ $room->note }}</td>
                                        <td class="border px-4 py-2">{{ $room->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Chưa có phòng nào.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>