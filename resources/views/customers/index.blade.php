<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Danh sách khách hàng
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Tìm kiếm, sắp xếp và phân trang danh sách khách hàng.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('customers.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
                    <div class="xl:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-slate-700">Từ khóa</label>
                        <input
                            type="text"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="Nhập tên, số điện thoại, email, CCCD, địa chỉ..."
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Sắp xếp theo</label>
                        <select name="sort_by" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">
                            <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                            <option value="full_name" {{ request('sort_by') == 'full_name' ? 'selected' : '' }}>Họ tên</option>
                            <option value="phone" {{ request('sort_by') == 'phone' ? 'selected' : '' }}>Số điện thoại</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Thứ tự</label>
                        <select name="sort_dir" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">
                            <option value="desc" {{ request('sort_dir', 'desc') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">Mỗi trang</label>
                        <select name="per_page" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500">
                            @foreach([10, 20, 50, 100] as $size)
                                <option value="{{ $size }}" {{ (int) request('per_page', 10) === $size ? 'selected' : '' }}>
                                    {{ $size }} dòng
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="xl:col-span-5 flex flex-wrap items-end gap-3">
                        <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">
                            Lọc
                        </button>

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
                            Hiển thị {{ $customers->firstItem() ?? 0 }} - {{ $customers->lastItem() ?? 0 }} / {{ $customers->total() }} khách hàng
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
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->phone ?: '—' }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->email ?: '—' }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->identity_number ?: '—' }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->address ?: '—' }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                                       class="rounded-lg bg-amber-500 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-600">
                                                        Sửa
                                                    </a>

                                                    <form action="{{ route('customers.destroy', $customer->id) }}"
                                                        method="POST"
                                                        data-confirm="true"
                                                        data-confirm-message="Bạn có chắc muốn xóa khách hàng này không?">
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

                        <div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <p class="text-sm text-slate-500">
                                Đang hiển thị {{ $customers->firstItem() ?? 0 }} - {{ $customers->lastItem() ?? 0 }} trong tổng {{ $customers->total() }} khách hàng
                            </p>

                            <div>
                                {{ $customers->links() }}
                            </div>
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