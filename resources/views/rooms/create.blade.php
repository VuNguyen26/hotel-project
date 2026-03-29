<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Thêm phòng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Tạo mới phòng và gán với loại phòng tương ứng.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="section-title">Nhập thông tin phòng</h3>
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

                    @if($roomTypes->count() == 0)
                        <div class="empty-state">
                            Bạn chưa có loại phòng nào. Hãy tạo loại phòng trước khi thêm phòng.
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('room-types.create') }}" class="btn-primary">Đi tạo loại phòng</a>
                        </div>
                    @else
                        <form action="{{ route('rooms.store') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label for="room_number" class="form-label">Số phòng</label>
                                <input type="text" name="room_number" id="room_number" value="{{ old('room_number') }}" class="form-input" placeholder="Ví dụ: 101, 202, VIP01">
                            </div>

                            <div>
                                <label for="room_type_id" class="form-label">Loại phòng</label>
                                <select name="room_type_id" id="room_type_id" class="form-select">
                                    <option value="">-- Chọn loại phòng --</option>
                                    @foreach($roomTypes as $roomType)
                                        <option value="{{ $roomType->id }}" {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
                                            {{ $roomType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="floor" class="form-label">Tầng</label>
                                <input type="number" name="floor" id="floor" value="{{ old('floor') }}" class="form-input" placeholder="Ví dụ: 1, 2, 3">
                            </div>

                            <div>
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Còn trống</option>
                                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Đã đặt</option>
                                    <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Đang sử dụng</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                                </select>
                            </div>

                            <div>
                                <label for="note" class="form-label">Ghi chú</label>
                                <textarea name="note" id="note" rows="4" class="form-textarea" placeholder="Nhập ghi chú nếu có">{{ old('note') }}</textarea>
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="submit" data-loading-text="Đang lưu phòng..." class="btn-primary">Lưu</button>
                                <a href="{{ route('rooms.index') }}" class="btn-secondary">Quay lại</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>