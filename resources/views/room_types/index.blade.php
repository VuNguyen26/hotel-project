<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Danh sách loại phòng
            </h2>

            <a href="{{ route('room-types.create') }}"
               class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                + Thêm loại phòng
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
                <h3 class="text-lg font-bold mb-4">Các loại phòng hiện có</h3>

                @if($roomTypes->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">ID</th>
                                    <th class="border px-4 py-2 text-left">Tên loại phòng</th>
                                    <th class="border px-4 py-2 text-left">Mô tả</th>
                                    <th class="border px-4 py-2 text-left">Giá</th>
                                    <th class="border px-4 py-2 text-left">Sức chứa</th>
                                    <th class="border px-4 py-2 text-left">Ngày tạo</th>
                                    <th class="border px-4 py-2 text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roomTypes as $roomType)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $roomType->id }}</td>
                                        <td class="border px-4 py-2">{{ $roomType->name }}</td>
                                        <td class="border px-4 py-2">{{ $roomType->description }}</td>
                                        <td class="border px-4 py-2">{{ number_format($roomType->price, 0, ',', '.') }} VNĐ</td>
                                        <td class="border px-4 py-2">{{ $roomType->capacity }}</td>
                                        <td class="border px-4 py-2">{{ $roomType->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="border px-4 py-2">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('room-types.edit', $roomType->id) }}"
                                                   class="rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600">
                                                    Sửa
                                                </a>

                                                <form action="{{ route('room-types.destroy', $roomType->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa loại phòng này không?');">
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
                    <p class="text-gray-500">Chưa có loại phòng nào.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>