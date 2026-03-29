<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Sửa khách hàng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Cập nhật hồ sơ khách hàng trong hệ thống.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="section-title">Cập nhật thông tin khách hàng</h3>
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

                    <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="full_name" class="form-label">Họ và tên</label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $customer->full_name) }}" class="form-input">
                        </div>

                        <div>
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}" class="form-input">
                        </div>

                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" class="form-input">
                        </div>

                        <div>
                            <label for="identity_number" class="form-label">CCCD / CMND</label>
                            <input type="text" name="identity_number" id="identity_number" value="{{ old('identity_number', $customer->identity_number) }}" class="form-input">
                        </div>

                        <div>
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $customer->address) }}" class="form-input">
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="btn-warning">Cập nhật</button>
                            <a href="{{ route('customers.index') }}" class="btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>