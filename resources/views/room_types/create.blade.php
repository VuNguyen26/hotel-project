<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Thêm loại phòng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Tạo mới loại phòng để sử dụng cho danh sách phòng.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="section-title">Nhập thông tin loại phòng</h3>
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

                    <form action="{{ route('room-types.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="form-label">Tên loại phòng</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-input" placeholder="Ví dụ: Standard, Deluxe, VIP">
                        </div>

                        <div>
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" rows="4" class="form-textarea" placeholder="Nhập mô tả loại phòng">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label for="price" class="form-label">Giá phòng</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" class="form-input" placeholder="Ví dụ: 500000">
                        </div>

                        <div>
                            <label for="capacity" class="form-label">Sức chứa</label>
                            <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" class="form-input" placeholder="Ví dụ: 2">
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" data-loading-text="Đang lưu loại phòng..." class="btn-primary">Lưu</button>
                            <a href="{{ route('room-types.index') }}" class="btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>