<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Danh sách phòng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Tìm kiếm và lọc phòng theo loại phòng, trạng thái và số phòng.
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
                <form action="{{ route('rooms.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
                    <div class="xl:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Từ khóa</label>
                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="Nhập số phòng hoặc ghi chú"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Loại phòng</label>
                        <select
                            name="room_type_id"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Tất cả</option>
                            @foreach($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}" {{ request('room_type_id') == $roomType->id ? 'selected' : '' }}>
                                    {{ $roomType->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Trạng thái</label>
                        <select
                            name="status"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Tất cả</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Còn trống</option>
                            <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Đã đặt</option>
                            <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Đang sử dụng</option>
                            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-3">
                        <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">
                            Lọc
                        </button>

                        <a href="{{ route('rooms.index') }}" class="rounded-xl bg-slate-200 px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-300">
                            Đặt lại
                        </a>
                    </div>
                </form>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Các phòng hiện có</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Kết quả tìm thấy: {{ $rooms->count() }} phòng
                        </p>
                    </div>

                    <a href="{{ route('rooms.create') }}"
                       class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                        + Thêm phòng
                    </a>
                </div>

                <div class="px-6 py-6">
                    @if($rooms->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-slate-50">
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">ID</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Số phòng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Loại phòng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Tầng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Trạng thái</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ghi chú</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ngày tạo</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-700">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rooms as $room)
                                        <tr class="hover:bg-slate-50">
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $room->id }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm font-medium text-slate-800">{{ $room->room_number }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $room->roomType->name }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $room->floor }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm">
                                                @if($room->status === 'available')
                                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Còn trống</span>
                                                @elseif($room->status === 'booked')
                                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Đã đặt</span>
                                                @elseif($room->status === 'occupied')
                                                    <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Đang sử dụng</span>
                                                @elseif($room->status === 'maintenance')
                                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Bảo trì</span>
                                                @endif
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $room->note }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $room->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('rooms.edit', $room->id) }}"
                                                       class="rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-600">
                                                        Sửa
                                                    </a>

                                                    <form action="{{ route('rooms.destroy', $room->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Bạn có chắc muốn xóa phòng này không?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-700">
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
                            Không tìm thấy phòng nào phù hợp.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>