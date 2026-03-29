<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Tạo đặt phòng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Chọn khách hàng, khoảng ngày lưu trú và phòng còn trống để tạo booking.
            </p>
        </div>
    </x-slot>

    @php
        $selectedCheckIn = old('check_in_date', $checkInDate ?? '');
        $selectedCheckOut = old('check_out_date', $checkOutDate ?? '');
    @endphp

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="section-title">Nhập thông tin đặt phòng</h3>
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

                    @if($customers->count() == 0)
                        <div class="empty-state">
                            Bạn cần có ít nhất 1 khách hàng trước khi tạo đặt phòng.
                        </div>

                        <div class="mt-4 flex gap-3">
                            <a href="{{ route('customers.create') }}" class="btn-primary">Đi tạo khách hàng</a>
                        </div>
                    @else
                        <div class="mb-6 rounded-2xl border border-blue-100 bg-blue-50 p-4">
                            <h4 class="text-sm font-semibold text-blue-900">Bước 1: Lọc phòng trống theo khoảng ngày</h4>

                            <form action="{{ route('bookings.create') }}" method="GET" class="mt-3 grid grid-cols-1 gap-4 md:grid-cols-3">
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
                                    <button type="submit" class="btn-primary">Lọc phòng trống</button>
                                    <a href="{{ route('bookings.create') }}" class="btn-secondary">Đặt lại</a>
                                </div>
                            </form>

                            @if($checkInDate && $checkOutDate)
                                <p class="mt-3 text-sm text-blue-800">
                                    Hệ thống đang hiển thị <strong>{{ $rooms->count() }}</strong> phòng không trùng lịch trong khoảng
                                    <strong>{{ \Carbon\Carbon::parse($checkInDate)->format('d/m/Y') }}</strong>
                                    đến
                                    <strong>{{ \Carbon\Carbon::parse($checkOutDate)->format('d/m/Y') }}</strong>.
                                </p>
                            @else
                                <p class="mt-3 text-sm text-amber-700">
                                    Hãy chọn ngày nhận phòng và ngày trả phòng trước, sau đó bấm <strong>Lọc phòng trống</strong>.
                                </p>
                            @endif
                        </div>

                        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label for="customer_id" class="form-label">Khách hàng</label>
                                <select name="customer_id" id="customer_id" class="form-select">
                                    <option value="">-- Chọn khách hàng --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
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
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            Phòng {{ $room->room_number }} - {{ $room->roomType->name }} - {{ number_format($room->roomType->price, 0, ',', '.') }} VNĐ/đêm
                                        </option>
                                    @empty
                                        <option value="" disabled>Không có phòng phù hợp trong khoảng ngày đã chọn</option>
                                    @endforelse
                                </select>
                                <p class="mt-1 text-xs text-slate-500">
                                    Hệ thống chỉ hiển thị các phòng không bị trùng lịch và không ở trạng thái bảo trì.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div>
                                    <label for="adults" class="form-label">Số người lớn</label>
                                    <input type="number" name="adults" id="adults" value="{{ old('adults', 1) }}" class="form-input">
                                </div>

                                <div>
                                    <label for="children" class="form-label">Số trẻ em</label>
                                    <input type="number" name="children" id="children" value="{{ old('children', 0) }}" class="form-input">
                                </div>
                            </div>

                            <div>
                                <label for="status" class="form-label">Trạng thái booking</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                    <option value="confirmed" {{ old('status', 'confirmed') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                    <option value="checked_in" {{ old('status') == 'checked_in' ? 'selected' : '' }}>Đã nhận phòng</option>
                                    <option value="checked_out" {{ old('status') == 'checked_out' ? 'selected' : '' }}>Đã trả phòng</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="submit" data-loading-text="Đang lưu booking..." class="btn-primary">Lưu</button>
                                <a href="{{ route('bookings.index') }}" class="btn-secondary">Quay lại</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>