<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Thêm phòng
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-6">Nhập thông tin phòng</h3>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($roomTypes->count() == 0)
                    <div class="rounded-lg bg-yellow-100 p-4 text-yellow-800">
                        Bạn chưa có loại phòng nào. Hãy tạo loại phòng trước khi thêm phòng.
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('room-types.create') }}"
                           class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                            Đi tạo loại phòng
                        </a>
                    </div>
                @else
                    <form action="{{ route('rooms.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="room_number" class="block text-sm font-medium text-gray-700 mb-1">
                                Số phòng
                            </label>
                            <input
                                type="text"
                                name="room_number"
                                id="room_number"
                                value="{{ old('room_number') }}"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Ví dụ: 101, 202, VIP01"
                            >
                        </div>

                        <div>
                            <label for="room_type_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Loại phòng
                            </label>
                            <select
                                name="room_type_id"
                                id="room_type_id"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">-- Chọn loại phòng --</option>
                                @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}" {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
                                        {{ $roomType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">
                                Tầng
                            </label>
                            <input
                                type="number"
                                name="floor"
                                id="floor"
                                value="{{ old('floor') }}"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Ví dụ: 1, 2, 3"
                            >
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                Trạng thái
                            </label>
                            <select
                                name="status"
                                id="status"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Còn trống</option>
                                <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Đã đặt</option>
                                <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Đang sử dụng</option>
                                <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                            </select>
                        </div>

                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700 mb-1">
                                Ghi chú
                            </label>
                            <textarea
                                name="note"
                                id="note"
                                rows="4"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Nhập ghi chú nếu có"
                            >{{ old('note') }}</textarea>
                        </div>

                        <div class="flex items-center gap-3">
                            <button
                                type="submit"
                                class="rounded-lg bg-blue-600 px-5 py-2 text-white hover:bg-blue-700"
                            >
                                Lưu
                            </button>

                            <a
                                href="{{ route('rooms.index') }}"
                                class="rounded-lg bg-gray-500 px-5 py-2 text-white hover:bg-gray-600"
                            >
                                Quay lại
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>