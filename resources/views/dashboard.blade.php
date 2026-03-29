<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                    Dashboard quản lý khách sạn
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Theo dõi nhanh tình hình phòng, khách hàng và booking trong hệ thống.
                </p>
            </div>

            <x-slot name="header">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                        Dashboard quản lý khách sạn
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Theo dõi nhanh tình hình phòng, khách hàng và booking trong hệ thống.
                    </p>
                </div>
            </x-slot>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-800 to-indigo-700 p-8 text-white shadow-xl">
                <div class="grid gap-6 lg:grid-cols-[1.3fr_0.7fr] lg:items-center">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.2em] text-blue-100">
                            Hotel Admin Panel
                        </p>
                        <h3 class="mt-3 text-3xl font-bold leading-tight">
                            Tổng quan hệ thống quản lý khách sạn
                        </h3>
                        <p class="mt-3 max-w-2xl text-sm text-blue-100">
                            Theo dõi nhanh số lượng phòng, khách hàng, booking và trạng thái vận hành
                            để demo hệ thống một cách trực quan hơn.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                            <div class="text-sm text-blue-100">Booking hiện có</div>
                            <div class="mt-2 text-3xl font-bold">{{ $totalBookings }}</div>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                            <div class="text-sm text-blue-100">Phòng hiện có</div>
                            <div class="mt-2 text-3xl font-bold">{{ $totalRooms }}</div>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                            <div class="text-sm text-blue-100">Khách hàng</div>
                            <div class="mt-2 text-3xl font-bold">{{ $totalCustomers }}</div>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                            <div class="text-sm text-blue-100">Loại phòng</div>
                            <div class="mt-2 text-3xl font-bold">{{ $totalRoomTypes }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Tổng loại phòng</p>
                            <h3 class="mt-3 text-4xl font-bold text-blue-600">{{ $totalRoomTypes }}</h3>
                        </div>
                        <div class="rounded-2xl bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-600">
                            Room Types
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Tổng số phòng</p>
                            <h3 class="mt-3 text-4xl font-bold text-emerald-600">{{ $totalRooms }}</h3>
                        </div>
                        <div class="rounded-2xl bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-600">
                            Rooms
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Tổng khách hàng</p>
                            <h3 class="mt-3 text-4xl font-bold text-violet-600">{{ $totalCustomers }}</h3>
                        </div>
                        <div class="rounded-2xl bg-violet-50 px-3 py-2 text-xs font-semibold text-violet-600">
                            Customers
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Tổng booking</p>
                            <h3 class="mt-3 text-4xl font-bold text-orange-500">{{ $totalBookings }}</h3>
                        </div>
                        <div class="rounded-2xl bg-orange-50 px-3 py-2 text-xs font-semibold text-orange-500">
                            Bookings
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Phòng còn trống</p>
                        <span class="h-3 w-3 rounded-full bg-emerald-500"></span>
                    </div>
                    <h3 class="mt-4 text-4xl font-bold text-emerald-600">{{ $availableRooms }}</h3>
                    <div class="mt-5 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $totalRooms > 0 ? ($availableRooms / $totalRooms) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Phòng đã đặt</p>
                        <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                    </div>
                    <h3 class="mt-4 text-4xl font-bold text-amber-500">{{ $bookedRooms }}</h3>
                    <div class="mt-5 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-amber-400" style="width: {{ $totalRooms > 0 ? ($bookedRooms / $totalRooms) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Phòng đang sử dụng</p>
                        <span class="h-3 w-3 rounded-full bg-rose-500"></span>
                    </div>
                    <h3 class="mt-4 text-4xl font-bold text-rose-500">{{ $occupiedRooms }}</h3>
                    <div class="mt-5 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-rose-500" style="width: {{ $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Phòng bảo trì</p>
                        <span class="h-3 w-3 rounded-full bg-slate-500"></span>
                    </div>
                    <h3 class="mt-4 text-4xl font-bold text-slate-600">{{ $maintenanceRooms }}</h3>
                    <div class="mt-5 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-slate-500" style="width: {{ $totalRooms > 0 ? ($maintenanceRooms / $totalRooms) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">5 booking mới nhất</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Theo dõi nhanh các lượt đặt phòng gần đây.
                        </p>
                    </div>

                    <a href="{{ route('bookings.index') }}"
                       class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        Xem tất cả
                    </a>
                </div>

                <div class="px-6 py-6">
                    @if($latestBookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full overflow-hidden rounded-2xl">
                                <thead>
                                    <tr class="bg-slate-50">
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">ID</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Khách hàng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Phòng</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ngày nhận</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Ngày trả</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Tổng tiền</th>
                                        <th class="border-b border-slate-200 px-4 py-3 text-left text-sm font-semibold text-slate-700">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestBookings as $booking)
                                        <tr class="hover:bg-slate-50">
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $booking->id }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm font-medium text-slate-800">{{ $booking->customer->full_name ?? '' }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">{{ $booking->room->room_number ?? '' }}</td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">
                                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm text-slate-700">
                                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm font-semibold text-slate-800">
                                                {{ number_format($booking->total_price, 0, ',', '.') }} VNĐ
                                            </td>
                                            <td class="border-b border-slate-100 px-4 py-4 text-sm">
                                                @if($booking->status === 'pending')
                                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Chờ xác nhận</span>
                                                @elseif($booking->status === 'confirmed')
                                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">Đã xác nhận</span>
                                                @elseif($booking->status === 'checked_in')
                                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Đã nhận phòng</span>
                                                @elseif($booking->status === 'checked_out')
                                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Đã trả phòng</span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Đã hủy</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-300 px-6 py-10 text-center text-slate-500">
                            Chưa có booking nào để hiển thị.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>