<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sửa đặt phòng
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-6">Cập nhật thông tin đặt phòng</h3>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Khách hàng
                        </label>
                        <select
                            name="customer_id"
                            id="customer_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">-- Chọn khách hàng --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $booking->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->full_name }} - {{ $customer->phone }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Phòng
                        </label>
                        <select
                            name="room_id"
                            id="room_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">-- Chọn phòng --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                    Phòng {{ $room->room_number }} - {{ $room->roomType->name }} - {{ number_format($room->roomType->price, 0, ',', '.') }} VNĐ/đêm
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="check_in_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Ngày nhận phòng
                        </label>
                        <input
                            type="date"
                            name="check_in_date"
                            id="check_in_date"
                            value="{{ old('check_in_date', $booking->check_in_date) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label for="check_out_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Ngày trả phòng
                        </label>
                        <input
                            type="date"
                            name="check_out_date"
                            id="check_out_date"
                            value="{{ old('check_out_date', $booking->check_out_date) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label for="adults" class="block text-sm font-medium text-gray-700 mb-1">
                            Số người lớn
                        </label>
                        <input
                            type="number"
                            name="adults"
                            id="adults"
                            value="{{ old('adults', $booking->adults) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label for="children" class="block text-sm font-medium text-gray-700 mb-1">
                            Số trẻ em
                        </label>
                        <input
                            type="number"
                            name="children"
                            id="children"
                            value="{{ old('children', $booking->children) }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Trạng thái booking
                        </label>
                        <select
                            name="status"
                            id="status"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="checked_in" {{ old('status', $booking->status) == 'checked_in' ? 'selected' : '' }}>Đã nhận phòng</option>
                            <option value="checked_out" {{ old('status', $booking->status) == 'checked_out' ? 'selected' : '' }}>Đã trả phòng</option>
                            <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="submit"
                            class="rounded-lg bg-yellow-500 px-5 py-2 text-white hover:bg-yellow-600"
                        >
                            Cập nhật
                        </button>

                        <a
                            href="{{ route('bookings.index') }}"
                            class="rounded-lg bg-gray-500 px-5 py-2 text-white hover:bg-gray-600"
                        >
                            Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>