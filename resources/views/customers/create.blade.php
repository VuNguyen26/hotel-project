<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Thêm khách hàng
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-6">Nhập thông tin khách hàng</h3>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
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
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Họ và tên
                        </label>
                        <input
                            type="text"
                            name="full_name"
                            id="full_name"
                            value="{{ old('full_name') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nhập họ và tên khách hàng"
                        >
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Số điện thoại
                        </label>
                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            value="{{ old('phone') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nhập số điện thoại"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nhập email"
                        >
                    </div>

                    <div>
                        <label for="identity_number" class="block text-sm font-medium text-gray-700 mb-1">
                            CCCD / CMND
                        </label>
                        <input
                            type="text"
                            name="identity_number"
                            id="identity_number"
                            value="{{ old('identity_number') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nhập CCCD hoặc CMND"
                        >
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                            Địa chỉ
                        </label>
                        <input
                            type="text"
                            name="address"
                            id="address"
                            value="{{ old('address') }}"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nhập địa chỉ"
                        >
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2 text-white hover:bg-blue-700"
                        >
                            Lưu
                        </button>

                        <a
                            href="{{ route('customers.index') }}"
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