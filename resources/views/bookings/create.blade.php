<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Tạo đặt phòng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Chọn khách hàng, phòng và thời gian lưu trú để tạo booking.
            </p>
        </div>
    </x-slot>

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

                    @if($customers->count() == 0 || $rooms->count() == 0)
                        <div class="empty-state">
                            Bạn cần có ít nhất 1 khách hàng và 1 phòng còn trống trước khi tạo đặt phòng.
                        </div>

                        <div class="mt-4 flex gap-3">
                            <a href="{{ route('customers.create') }}" class="btn-primary">Đi tạo khách hàng</a>
                            <a href="{{ route('rooms.create') }}" class="btn-success">Đi tạo phòng</a>
                        </div>
                    @else
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

                            <div>
                                <label for="room_id" class="form-label">Phòng</label>
                                <select name="room_id" id="room_id" class="form-select">
                                    <option value="">-- Chọn phòng --</option>
                                    @foreach($rooms as $room)
                                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            Phòng {{ $room->room_number }} - {{ $room->roomType->name }} - {{ number_format($room->roomType->price, 0, ',', '.') }} VNĐ/đêm
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="check_in_date" class="form-label">Ngày nhận phòng</label>
                                <input type="date" name="check_in_date" id="check_in_date" value="{{ old('check_in_date') }}" class="form-input">
                            </div>

                            <div>
                                <label for="check_out_date" class="form-label">Ngày trả phòng</label>
                                <input type="date" name="check_out_date" id="check_out_date" value="{{ old('check_out_date') }}" class="form-input">
                            </div>

                            <div>
                                <label for="adults" class="form-label">Số người lớn</label>
                                <input type="number" name="adults" id="adults" value="{{ old('adults', 1) }}" class="form-input">
                            </div>

                            <div>
                                <label for="children" class="form-label">Số trẻ em</label>
                                <input type="number" name="children" id="children" value="{{ old('children', 0) }}" class="form-input">
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
                                <button type="submit" class="btn-primary">Lưu</button>
                                <a href="{{ route('bookings.index') }}" class="btn-secondary">Quay lại</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>