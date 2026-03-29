<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Thêm khách hàng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Tạo hồ sơ khách hàng để phục vụ đặt phòng và thanh toán.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="section-title">Nhập thông tin khách hàng</h3>
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

                    <form action="{{ route('customers.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="full_name" class="form-label">Họ và tên</label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="form-input" placeholder="Nhập họ và tên khách hàng">
                        </div>

                        <div>
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-input" placeholder="Nhập số điện thoại">
                        </div>

                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input" placeholder="Nhập email">
                        </div>

                        <div>
                            <label for="identity_number" class="form-label">CCCD / CMND</label>
                            <input type="text" name="identity_number" id="identity_number" value="{{ old('identity_number') }}" class="form-input" placeholder="Nhập CCCD hoặc CMND">
                        </div>

                        <div>
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-input" placeholder="Nhập địa chỉ">
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="btn-primary">Lưu</button>
                            <a href="{{ route('customers.index') }}" class="btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>