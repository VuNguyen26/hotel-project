<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Sửa phòng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Cập nhật thông tin phòng và trạng thái sử dụng.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="section-title">Cập nhật thông tin phòng</h3>
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

                    <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="room_number" class="form-label">Số phòng</label>
                            <input type="text" name="room_number" id="room_number" value="{{ old('room_number', $room->room_number) }}" class="form-input">
                        </div>

                        <div>
                            <label for="room_type_id" class="form-label">Loại phòng</label>
                            <select name="room_type_id" id="room_type_id" class="form-select">
                                <option value="">-- Chọn loại phòng --</option>
                                @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}" {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}>
                                        {{ $roomType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="floor" class="form-label">Tầng</label>
                            <input type="number" name="floor" id="floor" value="{{ old('floor', $room->floor) }}" class="form-input">
                        </div>

                        <div>
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-select">
                                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Còn trống</option>
                                <option value="booked" {{ old('status', $room->status) == 'booked' ? 'selected' : '' }}>Đã đặt</option>
                                <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Đang sử dụng</option>
                                <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                            </select>
                        </div>

                        <div>
                            <label for="note" class="form-label">Ghi chú</label>
                            <textarea name="note" id="note" rows="4" class="form-textarea">{{ old('note', $room->note) }}</textarea>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="btn-warning">Cập nhật</button>
                            <a href="{{ route('rooms.index') }}" class="btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>