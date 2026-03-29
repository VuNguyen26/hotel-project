<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Sửa đặt phòng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Cập nhật thông tin booking và lọc lại phòng còn trống theo khoảng ngày.
            </p>
        </div>
    </x-slot>

    @php
        $selectedCheckIn = old('check_in_date', $checkInDate ?? $booking->check_in_date);
        $selectedCheckOut = old('check_out_date', $checkOutDate ?? $booking->check_out_date);
    @endphp

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="section-title">Cập nhật thông tin đặt phòng</h3>
                </div>

                <div class="form-card-body">
                    @if ($errors->any())
                        <div class="alert-error mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-6 rounded-2xl border border-amber-100 bg-amber-50 p-4">
                        <h4 class="text-sm font-semibold text-amber-900">Bước 1: Lọc lại phòng trống theo ngày mới</h4>

                        <form action="{{ route('bookings.edit', $booking->id) }}" method="GET" class="mt-3 grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div>
                                <label for="filter_check_in_date" class="form-label">Ngày nhận phòng</label>
                                <input
                                    type="date"
                                    name="check_in_date"
                                    id="filter_check_in_date"
                                    value="{{ $checkInDate }}"
                                    class="form-input"
                                >
                            </div>

                            <div>
                                <label for="filter_check_out_date" class="form-label">Ngày trả phòng</label>
                                <input
                                    type="date"
                                    name="check_out_date"
                                    id="filter_check_out_date"
                                    value="{{ $checkOutDate }}"
                                    class="form-input"
                                >
                            </div>

                            <div class="flex items-end gap-3">
                                <button type="submit" class="btn-warning">Lọc lại phòng</button>
                                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn-secondary">Đặt lại</a>
                            </div>
                        </form>

                        @if($checkInDate && $checkOutDate)
                            <p class="mt-3 text-sm text-amber-800">
                                Hệ thống đang hiển thị <strong>{{ $rooms->count() }}</strong> phòng phù hợp cho khoảng
                                <strong>{{ \Carbon\Carbon::parse($checkInDate)->format('d/m/Y') }}</strong>
                                đến
                                <strong>{{ \Carbon\Carbon::parse($checkOutDate)->format('d/m/Y') }}</strong>.
                            </p>
                        @endif
                    </div>

                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="customer_id" class="form-label">Khách hàng</label>
                            <select name="customer_id" id="customer_id" class="form-select">
                                <option value="">-- Chọn khách hàng --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', $booking->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->full_name }} - {{ $customer->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="check_in_date" class="form-label">Ngày nhận phòng</label>
                                <input type="date" name="check_in_date" id="check_in_date" value="{{ $selectedCheckIn }}" class="form-input">
                            </div>

                            <div>
                                <label for="check_out_date" class="form-label">Ngày trả phòng</label>
                                <input type="date" name="check_out_date" id="check_out_date" value="{{ $selectedCheckOut }}" class="form-input">
                            </div>
                        </div>

                        <div>
                            <label for="room_id" class="form-label">Phòng</label>
                            <select name="room_id" id="room_id" class="form-select">
                                <option value="">-- Chọn phòng --</option>
                                @forelse($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                        Phòng {{ $room->room_number }} - {{ $room->roomType->name }} - {{ number_format($room->roomType->price, 0, ',', '.') }} VNĐ/đêm
                                    </option>
                                @empty
                                    <option value="" disabled>Không có phòng phù hợp trong khoảng ngày đã chọn</option>
                                @endforelse
                            </select>
                            <p class="mt-1 text-xs text-slate-500">
                                Booking hiện tại đã được loại khỏi kiểm tra trùng lịch, nên bạn vẫn có thể giữ nguyên phòng cũ nếu lịch đó hợp lệ.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="adults" class="form-label">Số người lớn</label>
                                <input type="number" name="adults" id="adults" value="{{ old('adults', $booking->adults) }}" class="form-input">
                            </div>

                            <div>
                                <label for="children" class="form-label">Số trẻ em</label>
                                <input type="number" name="children" id="children" value="{{ old('children', $booking->children) }}" class="form-input">
                            </div>
                        </div>

                        <div>
                            <label for="status" class="form-label">Trạng thái booking</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="checked_in" {{ old('status', $booking->status) == 'checked_in' ? 'selected' : '' }}>Đã nhận phòng</option>
                                <option value="checked_out" {{ old('status', $booking->status) == 'checked_out' ? 'selected' : '' }}>Đã trả phòng</option>
                                <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="btn-warning">Cập nhật</button>
                            <a href="{{ route('bookings.index') }}" class="btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>