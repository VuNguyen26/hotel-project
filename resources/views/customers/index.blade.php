<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Danh sách khách hàng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Tìm kiếm khách hàng theo tên, số điện thoại, email, CCCD hoặc địa chỉ.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('customers.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-[1fr_auto_auto]">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Từ khóa</label>
                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="Nhập tên, số điện thoại, email, CCCD, địa chỉ..."
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">
                            Lọc
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('customers.index') }}" class="rounded-xl bg-slate-200 px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-300">
                            Đặt lại
                        </a>
                    </div>
                </form>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Các khách hàng hiện có</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Kết quả tìm thấy: {{ $customers->count() }} khách hàng
                        </p>
                    </div>

                    <a href="{{ route('customers.create') }}"
                       class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                        + Thêm khách hàng
                    </a>
                </div>

                <div class="px-6 py-6">
                    @if($customers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-slate-50">
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">ID</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Họ và tên</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Số điện thoại</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Email</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">CCCD / CMND</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Địa chỉ</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ngày tạo</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-center text-sm font-semibold text-slate-700">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                        <tr class="hover:bg-slate-50">
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->id }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm font-medium text-slate-800">{{ $customer->full_name }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->phone }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->email }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->identity_number }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->address }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                                       class="rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-600">
                                                        Sửa
                                                    </a>

                                                    <form action="{{ route('customers.destroy', $customer->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này không?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="rounded-lg bg-rose-600 px-3 py-2 text-xs font-semibold text-white hover:bg-rose-700">
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
                        <div class="rounded-2xl border border-dashed border-slate-300 px-6 py-10 text-center text-slate-500">
                            Không tìm thấy khách hàng nào phù hợp.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>