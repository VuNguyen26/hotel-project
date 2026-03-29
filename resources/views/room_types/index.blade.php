<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Danh sách loại phòng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Quản lý thông tin loại phòng, giá và sức chứa.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="page-shell space-y-6">
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="section-card">
                <div class="section-header">
                    <div>
                        <h3 class="section-title">Các loại phòng hiện có</h3>
                        <p class="section-subtitle">Tổng cộng {{ $roomTypes->count() }} loại phòng</p>
                    </div>

                    <a href="{{ route('room-types.create') }}" class="btn-primary">
                        + Thêm loại phòng
                    </a>
                </div>

                <div class="content-pad">
                    @if($roomTypes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên loại phòng</th>
                                        <th>Mô tả</th>
                                        <th>Giá</th>
                                        <th>Sức chứa</th>
                                        <th>Ngày tạo</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roomTypes as $roomType)
                                        <tr>
                                            <td>{{ $roomType->id }}</td>
                                            <td class="font-medium text-slate-800">{{ $roomType->name }}</td>
                                            <td>{{ $roomType->description }}</td>
                                            <td class="font-semibold text-slate-800">{{ number_format($roomType->price, 0, ',', '.') }} VNĐ</td>
                                            <td>
                                                <span class="badge badge-blue">{{ $roomType->capacity }} người</span>
                                            </td>
                                            <td>{{ $roomType->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="action-group">
                                                    <a href="{{ route('room-types.edit', $roomType->id) }}" class="btn-warning">
                                                        Sửa
                                                    </a>

                                                    <form action="{{ route('room-types.destroy', $roomType->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Bạn có chắc muốn xóa loại phòng này không?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-danger">
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
                        <div class="empty-state">
                            Chưa có loại phòng nào.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>