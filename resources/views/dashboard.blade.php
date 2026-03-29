<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Dashboard quản lý khách sạn
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Theo dõi nhanh phòng, khách hàng, booking, doanh thu và hiệu suất vận hành.
            </p>
        </div>
    </x-slot>

    <div class="bg-[#F4F8FB] py-8">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 sm:px-6 lg:px-8">

            {{-- Hero premium --}}
            <div class="overflow-hidden rounded-[30px] bg-gradient-to-r from-[#163A7D] via-[#1D458F] to-[#2550A4] shadow-[0_24px_70px_rgba(22,58,125,0.18)]">
                <div class="grid gap-8 px-8 py-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                    <div>
                        <div class="inline-flex rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-white/70">
                            Premium dashboard
                        </div>

                        <h3 class="mt-5 text-3xl font-bold leading-tight text-white md:text-4xl">
                            Tổng quan hệ thống quản lý khách sạn
                        </h3>

                        <p class="mt-4 max-w-2xl text-sm leading-7 text-white/75">
                            Theo dõi booking, doanh thu, tỷ lệ lấp phòng và trạng thái vận hành trong
                            một giao diện trực quan, hiện đại và dễ demo.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('bookings.create') }}"
                               class="rounded-2xl bg-[#20D3B3] px-5 py-3 text-sm font-semibold text-[#163A7D] transition hover:brightness-95">
                                Tạo booking
                            </a>

                            <a href="{{ route('payments.index') }}"
                               class="rounded-2xl border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                                Xem thanh toán
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <div class="text-sm font-medium text-white/70">Doanh thu đã thu</div>
                            <div class="mt-4 text-3xl font-bold text-white">
                                {{ number_format($totalCollected, 0, ',', '.') }} VNĐ
                            </div>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <div class="text-sm font-medium text-white/70">Tỷ lệ lấp phòng</div>
                            <div class="mt-4 text-3xl font-bold text-white">{{ $occupancyRate }}%</div>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <div class="text-sm font-medium text-white/70">Giao dịch đã thu</div>
                            <div class="mt-4 text-3xl font-bold text-white">{{ $paidTransactions }}</div>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-sm">
                            <div class="text-sm font-medium text-white/70">Booking hiện có</div>
                            <div class="mt-4 text-3xl font-bold text-white">{{ $totalBookings }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KPI cards with mini charts --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-sm font-medium text-slate-500">Tổng loại phòng</div>
                            <div class="mt-4 text-4xl font-bold text-[#163A7D] stat-counter" data-value="{{ $totalRoomTypes }}">0</div>
                        </div>
                        <span class="rounded-full bg-[#EEF4FF] px-3 py-1 text-xs font-semibold text-[#2F5FD7]">
                            Room Types
                        </span>
                    </div>
                    <div class="mt-6 h-[70px]">
                        <canvas id="roomTypeSparkChart"></canvas>
                    </div>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-sm font-medium text-slate-500">Tổng số phòng</div>
                            <div class="mt-4 text-4xl font-bold text-[#163A7D] stat-counter" data-value="{{ $totalRooms }}">0</div>
                        </div>
                        <span class="rounded-full bg-[#EAFBF7] px-3 py-1 text-xs font-semibold text-[#169F87]">
                            Rooms
                        </span>
                    </div>
                    <div class="mt-6 h-[70px]">
                        <canvas id="roomSparkChart"></canvas>
                    </div>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-sm font-medium text-slate-500">Tổng khách hàng</div>
                            <div class="mt-4 text-4xl font-bold text-[#163A7D] stat-counter" data-value="{{ $totalCustomers }}">0</div>
                        </div>
                        <span class="rounded-full bg-[#F4F0FF] px-3 py-1 text-xs font-semibold text-[#7B57E8]">
                            Customers
                        </span>
                    </div>
                    <div class="mt-6 h-[70px]">
                        <canvas id="customerSparkChart"></canvas>
                    </div>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-sm font-medium text-slate-500">Tổng booking</div>
                            <div class="mt-4 text-4xl font-bold text-[#163A7D] stat-counter" data-value="{{ $totalBookings }}">0</div>
                        </div>
                        <span class="rounded-full bg-[#FFF3E8] px-3 py-1 text-xs font-semibold text-[#F08A24]">
                            Bookings
                        </span>
                    </div>
                    <div class="mt-6 h-[70px]">
                        <canvas id="bookingSparkChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Room status cards --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-slate-500">Phòng còn trống</div>
                        <span class="h-3 w-3 rounded-full bg-[#20D3B3]"></span>
                    </div>
                    <div class="mt-4 text-4xl font-bold text-[#163A7D] stat-counter" data-value="{{ $availableRooms }}">0</div>
                    <div class="mt-6 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-[#20D3B3]" style="width: {{ $totalRooms > 0 ? ($availableRooms / $totalRooms) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-slate-500">Phòng đã đặt</div>
                        <span class="h-3 w-3 rounded-full bg-[#F2B321]"></span>
                    </div>
                    <div class="mt-4 text-4xl font-bold text-[#163A7D] stat-counter" data-value="{{ $bookedRooms }}">0</div>
                    <div class="mt-6 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-[#F2B321]" style="width: {{ $totalRooms > 0 ? ($bookedRooms / $totalRooms) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-slate-500">Phòng đang sử dụng</div>
                        <span class="h-3 w-3 rounded-full bg-[#F0526D]"></span>
                    </div>
                    <div class="mt-4 text-4xl font-bold text-[#163A7D] stat-counter" data-value="{{ $occupiedRooms }}">0</div>
                    <div class="mt-6 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-[#F0526D]" style="width: {{ $totalRooms > 0 ? ($occupiedRooms / $totalRooms) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-slate-500">Phòng bảo trì</div>
                        <span class="h-3 w-3 rounded-full bg-[#94A3B8]"></span>
                    </div>
                    <div class="mt-4 text-4xl font-bold text-[#163A7D] stat-counter" data-value="{{ $maintenanceRooms }}">0</div>
                    <div class="mt-6 h-2 rounded-full bg-slate-100">
                        <div class="h-2 rounded-full bg-[#94A3B8]" style="width: {{ $totalRooms > 0 ? ($maintenanceRooms / $totalRooms) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>

                        {{-- Advanced report KPI --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="text-sm font-medium text-slate-500">Doanh thu tháng này</div>
                    <div class="mt-4 text-3xl font-bold text-[#163A7D]">
                        {{ number_format($revenueThisMonth, 0, ',', '.') }} VNĐ
                    </div>
                    <p class="mt-3 text-sm text-slate-500">
                        Tổng tiền đã thu trong tháng hiện tại.
                    </p>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="text-sm font-medium text-slate-500">Booking tháng này</div>
                    <div class="mt-4 text-3xl font-bold text-[#163A7D]">
                        {{ number_format($bookingsThisMonth, 0, ',', '.') }}
                    </div>
                    <p class="mt-3 text-sm text-slate-500">
                        Số booking được tạo trong tháng hiện tại.
                    </p>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="text-sm font-medium text-slate-500">Giá trị booking trung bình</div>
                    <div class="mt-4 text-3xl font-bold text-[#163A7D]">
                        {{ number_format($averageBookingValueThisMonth, 0, ',', '.') }} VNĐ
                    </div>
                    <p class="mt-3 text-sm text-slate-500">
                        Trung bình tổng tiền mỗi booking trong tháng.
                    </p>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="text-sm font-medium text-slate-500">Công nợ còn lại</div>
                    <div class="mt-4 text-3xl font-bold text-[#D63C62]">
                        {{ number_format($outstandingBalance, 0, ',', '.') }} VNĐ
                    </div>
                    <p class="mt-3 text-sm text-slate-500">
                        Tổng số tiền chưa thu hết ở các booking chưa hủy.
                    </p>
                </div>
            </div>

            {{-- Main charts row --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm xl:col-span-2">
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Doanh thu 6 tháng gần nhất</h3>
                        <p class="mt-1 text-sm text-slate-500">Biểu đồ đường thể hiện doanh thu theo tháng.</p>
                    </div>
                    <div class="h-[340px]">
                        <canvas id="revenueLineChart"></canvas>
                    </div>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Tình trạng phòng</h3>
                        <p class="mt-1 text-sm text-slate-500">Tỷ trọng các trạng thái phòng hiện tại.</p>
                    </div>
                    <div class="h-[340px] flex items-center justify-center">
                        <canvas id="roomStatusDoughnutChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Secondary charts row --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm xl:col-span-2">
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Booking 6 tháng gần nhất</h3>
                        <p class="mt-1 text-sm text-slate-500">Biểu đồ cột thể hiện số lượng booking theo tháng.</p>
                    </div>
                    <div class="h-[340px]">
                        <canvas id="bookingBarChart"></canvas>
                    </div>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Thanh toán theo phương thức</h3>
                        <p class="mt-1 text-sm text-slate-500">Phân bổ doanh thu theo cách thanh toán.</p>
                    </div>
                    <div class="h-[340px] flex items-center justify-center">
                        <canvas id="paymentMethodDoughnutChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Booking status chart --}}
            <div class="grid grid-cols-1 gap-6">
                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Booking theo trạng thái</h3>
                        <p class="mt-1 text-sm text-slate-500">Biểu đồ polar area thể hiện tình trạng booking trong hệ thống.</p>
                    </div>
                    <div class="h-[380px]">
                        <canvas id="bookingStatusPolarChart"></canvas>
                    </div>
                </div>
            </div>

                        {{-- Advanced report charts --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm xl:col-span-2">
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Doanh thu 14 ngày gần nhất</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Kết hợp doanh thu đã thu và số booking tạo mới theo từng ngày.
                        </p>
                    </div>
                    <div class="h-[360px]">
                        <canvas id="dailyRevenueMixedChart"></canvas>
                    </div>
                </div>

                <div class="rounded-[28px] border border-[#E6EEF5] bg-white p-6 shadow-sm">
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-slate-900">Top loại phòng được đặt nhiều</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Xếp hạng theo số lượng booking không bị hủy.
                        </p>
                    </div>
                    <div class="h-[360px]">
                        <canvas id="topRoomTypeBarChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Advanced report tables --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="overflow-hidden rounded-[28px] border border-[#E6EEF5] bg-white shadow-sm xl:col-span-2">
                    <div class="flex items-center justify-between border-b border-[#EEF3F8] px-6 py-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">5 booking còn nợ cao nhất</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Các booking cần ưu tiên theo dõi công nợ.
                            </p>
                        </div>
                    </div>

                    <div class="px-6 py-6">
                        @if($topOutstandingBookings->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-[#F7FAFD]">
                                            <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Booking</th>
                                            <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Khách hàng</th>
                                            <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Phòng</th>
                                            <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Tổng tiền</th>
                                            <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Đã thanh toán</th>
                                            <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Còn lại</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($topOutstandingBookings as $booking)
                                            <tr class="hover:bg-[#FAFCFE]">
                                                <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm font-semibold text-slate-800">
                                                    #{{ $booking->id }}
                                                </td>
                                                <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm text-slate-700">
                                                    {{ $booking->customer->full_name ?? '—' }}
                                                </td>
                                                <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm text-slate-700">
                                                    {{ $booking->room->room_number ?? '—' }}
                                                </td>
                                                <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm font-semibold text-slate-800">
                                                    {{ number_format($booking->total_price, 0, ',', '.') }} VNĐ
                                                </td>
                                                <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm text-[#169F87] font-semibold">
                                                    {{ number_format($booking->paid_amount_display, 0, ',', '.') }} VNĐ
                                                </td>
                                                <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm text-[#D63C62] font-bold">
                                                    {{ number_format($booking->remaining_amount, 0, ',', '.') }} VNĐ
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="rounded-2xl border border-dashed border-[#D7E3EE] px-6 py-12 text-center text-slate-500">
                                Hiện chưa có booking nào còn công nợ.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="overflow-hidden rounded-[28px] border border-[#E6EEF5] bg-white shadow-sm">
                    <div class="border-b border-[#EEF3F8] px-6 py-6">
                        <h3 class="text-xl font-bold text-slate-900">Báo cáo theo loại phòng</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Thống kê loại phòng nổi bật theo lượt đặt và doanh thu.
                        </p>
                    </div>

                    <div class="px-6 py-6">
                        @if($topRoomTypes->count() > 0)
                            <div class="space-y-4">
                                @foreach($topRoomTypes as $roomType)
                                    <div class="rounded-2xl border border-[#EEF3F8] p-4">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <h4 class="text-sm font-bold text-slate-900">{{ $roomType->name }}</h4>
                                                <p class="mt-1 text-xs text-slate-500">
                                                    {{ $roomType->rooms_count }} phòng • Giá {{ number_format($roomType->price, 0, ',', '.') }} VNĐ
                                                </p>
                                            </div>

                                            <span class="rounded-full bg-[#EEF4FF] px-3 py-1 text-xs font-semibold text-[#2F5FD7]">
                                                {{ $roomType->bookings_count }} booking
                                            </span>
                                        </div>

                                        <div class="mt-4 h-2 rounded-full bg-slate-100">
                                            <div class="h-2 rounded-full bg-[#20D3B3]"
                                                 style="width: {{ $topRoomTypes->max('bookings_count') > 0 ? ($roomType->bookings_count / $topRoomTypes->max('bookings_count')) * 100 : 0 }}%">
                                            </div>
                                        </div>

                                        <div class="mt-3 text-sm font-semibold text-slate-700">
                                            Doanh thu dự kiến: {{ number_format($roomType->revenue_total, 0, ',', '.') }} VNĐ
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-2xl border border-dashed border-[#D7E3EE] px-6 py-12 text-center text-slate-500">
                                Chưa có dữ liệu loại phòng để thống kê.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Operation + recent payments --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <div class="overflow-hidden rounded-[28px] border border-[#E6EEF5] bg-white shadow-sm">
                    <div class="border-b border-[#EEF3F8] px-6 py-6">
                        <h3 class="text-xl font-bold text-slate-900">Vận hành hôm nay</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Các chỉ số cần theo dõi ngay trong ngày.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 px-6 py-6 sm:grid-cols-3">
                        <div class="rounded-2xl border border-[#EEF3F8] bg-[#F8FBFE] p-5">
                            <div class="text-sm font-medium text-slate-500">Check-in hôm nay</div>
                            <div class="mt-4 text-3xl font-bold text-[#169F87]">{{ $todayCheckIns }}</div>
                        </div>

                        <div class="rounded-2xl border border-[#EEF3F8] bg-[#F8FBFE] p-5">
                            <div class="text-sm font-medium text-slate-500">Check-out hôm nay</div>
                            <div class="mt-4 text-3xl font-bold text-[#2F5FD7]">{{ $todayCheckOuts }}</div>
                        </div>

                        <div class="rounded-2xl border border-[#EEF3F8] bg-[#F8FBFE] p-5">
                            <div class="text-sm font-medium text-slate-500">Booking còn nợ</div>
                            <div class="mt-4 text-3xl font-bold text-[#D63C62]">{{ $unpaidBookingCount }}</div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-[28px] border border-[#E6EEF5] bg-white shadow-sm">
                    <div class="border-b border-[#EEF3F8] px-6 py-6">
                        <h3 class="text-xl font-bold text-slate-900">5 thanh toán mới nhất</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Theo dõi các giao dịch vừa được ghi nhận.
                        </p>
                    </div>

                    <div class="px-6 py-6">
                        @if($recentPayments->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentPayments as $payment)
                                    <div class="flex items-start justify-between gap-4 rounded-2xl border border-[#EEF3F8] p-4">
                                        <div>
                                            <div class="text-sm font-bold text-slate-900">
                                                Booking #{{ $payment->booking->id ?? '—' }} -
                                                {{ $payment->booking->customer->full_name ?? '—' }}
                                            </div>
                                            <div class="mt-1 text-sm text-slate-500">
                                                Phòng {{ $payment->booking->room->room_number ?? '—' }} •
                                                {{ optional($payment->paid_at)->format('d/m/Y H:i') }}
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <div class="text-sm font-bold text-[#169F87]">
                                                {{ number_format($payment->amount, 0, ',', '.') }} VNĐ
                                            </div>
                                            <div class="mt-1 text-xs text-slate-500">
                                                @if($payment->payment_method === 'cash')
                                                    Tiền mặt
                                                @elseif($payment->payment_method === 'transfer')
                                                    Chuyển khoản
                                                @elseif($payment->payment_method === 'card')
                                                    Thẻ
                                                @else
                                                    —
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-2xl border border-dashed border-[#D7E3EE] px-6 py-12 text-center text-slate-500">
                                Chưa có giao dịch thanh toán nào.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Latest bookings --}}
            <div class="overflow-hidden rounded-[28px] border border-[#E6EEF5] bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-[#EEF3F8] px-6 py-6">
                    <div>
                        <h3 class="text-[30px] font-bold tracking-tight text-slate-900">5 booking mới nhất</h3>
                        <p class="mt-2 text-sm text-slate-500">
                            Theo dõi nhanh các lượt đặt phòng gần đây.
                        </p>
                    </div>

                    <a href="{{ route('bookings.index') }}"
                       class="rounded-2xl border border-[#E6EEF5] bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Xem tất cả
                    </a>
                </div>

                <div class="px-6 py-6">
                    @if($latestBookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full overflow-hidden rounded-2xl">
                                <thead>
                                    <tr class="bg-[#F7FAFD]">
                                        <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">ID</th>
                                        <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Khách hàng</th>
                                        <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Phòng</th>
                                        <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Ngày nhận</th>
                                        <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Ngày trả</th>
                                        <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Tổng tiền</th>
                                        <th class="border-b border-[#EAF0F5] px-4 py-4 text-left text-sm font-semibold text-slate-700">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestBookings as $booking)
                                        <tr class="hover:bg-[#FAFCFE]">
                                            <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm text-slate-700">{{ $booking->id }}</td>
                                            <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm font-medium text-slate-800">{{ $booking->customer->full_name ?? '' }}</td>
                                            <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm text-slate-700">{{ $booking->room->room_number ?? '' }}</td>
                                            <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm text-slate-700">
                                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm text-slate-700">
                                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm font-semibold text-slate-900">
                                                {{ number_format($booking->total_price, 0, ',', '.') }} VNĐ
                                            </td>
                                            <td class="border-b border-[#EEF3F8] px-4 py-4 text-sm">
                                                @if($booking->status === 'pending')
                                                    <span class="inline-flex rounded-full bg-[#FFF4D8] px-3 py-1 text-xs font-semibold text-[#A56A00]">
                                                        Chờ xác nhận
                                                    </span>
                                                @elseif($booking->status === 'confirmed')
                                                    <span class="inline-flex rounded-full bg-[#EAF1FF] px-3 py-1 text-xs font-semibold text-[#2F5FD7]">
                                                        Đã xác nhận
                                                    </span>
                                                @elseif($booking->status === 'checked_in')
                                                    <span class="inline-flex rounded-full bg-[#EAFBF7] px-3 py-1 text-xs font-semibold text-[#169F87]">
                                                        Đã nhận phòng
                                                    </span>
                                                @elseif($booking->status === 'checked_out')
                                                    <span class="inline-flex rounded-full bg-[#EEF3F8] px-3 py-1 text-xs font-semibold text-slate-700">
                                                        Đã trả phòng
                                                    </span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="inline-flex rounded-full bg-[#FFE7EC] px-3 py-1 text-xs font-semibold text-[#D63C62]">
                                                        Đã hủy
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-[#D7E3EE] px-6 py-12 text-center text-slate-500">
                            Chưa có booking nào để hiển thị.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = @json($chartLabels);
            const bookingData = @json($bookingChartData);
            const revenueData = @json($revenueChartData);

            const roomTypeSparkData = @json($roomTypeSparkData);
            const roomSparkData = @json($roomSparkData);
            const customerSparkData = @json($customerSparkData);
            const bookingSparkData = @json($bookingSparkData);

            const roomStatusLabels = @json($roomStatusLabels);
            const roomStatusData = @json($roomStatusData);

            const paymentMethodLabels = @json($paymentMethodLabels);
            const paymentMethodData = @json($paymentMethodData);

            const bookingStatusLabels = @json($bookingStatusLabels);
            const bookingStatusData = @json($bookingStatusData);
            const dailyRevenueLabels = @json($dailyRevenueLabels);
            const dailyRevenueData = @json($dailyRevenueData);
            const dailyBookingData = @json($dailyBookingData);

            const topRoomTypeLabels = @json($topRoomTypeLabels);
            const topRoomTypeBookingData = @json($topRoomTypeBookingData);

            const gridColor = '#EAF0F5';
            const labelColor = '#64748B';

            function animateCounters() {
                const counters = document.querySelectorAll('.stat-counter');

                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-value')) || 0;
                    const duration = 1200;
                    const startTime = performance.now();

                    function update(currentTime) {
                        const progress = Math.min((currentTime - startTime) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        counter.textContent = Math.floor(eased * target).toLocaleString('vi-VN');

                        if (progress < 1) {
                            requestAnimationFrame(update);
                        } else {
                            counter.textContent = target.toLocaleString('vi-VN');
                        }
                    }

                    requestAnimationFrame(update);
                });
            }

            function createSparkline(canvasId, data, color) {
                const ctx = document.getElementById(canvasId);
                if (!ctx) return;

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            borderColor: color,
                            backgroundColor: color + '22',
                            fill: true,
                            tension: 0.45,
                            pointRadius: 0,
                            borderWidth: 3
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        },
                        scales: {
                            x: { display: false },
                            y: { display: false }
                        }
                    }
                });
            }

            createSparkline('roomTypeSparkChart', roomTypeSparkData, '#2F5FD7');
            createSparkline('roomSparkChart', roomSparkData, '#20D3B3');
            createSparkline('customerSparkChart', customerSparkData, '#7B57E8');
            createSparkline('bookingSparkChart', bookingSparkData, '#F08A24');

            const revenueCtx = document.getElementById('revenueLineChart');
            if (revenueCtx) {
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Doanh thu',
                            data: revenueData,
                            borderColor: '#20D3B3',
                            backgroundColor: 'rgba(32, 211, 179, 0.14)',
                            fill: true,
                            tension: 0.42,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#20D3B3',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: labelColor,
                                    font: { weight: '600' }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { color: gridColor },
                                ticks: { color: labelColor }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: gridColor },
                                ticks: {
                                    color: labelColor,
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN').format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            }

            const bookingCtx = document.getElementById('bookingBarChart');
            if (bookingCtx) {
                new Chart(bookingCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Số booking',
                            data: bookingData,
                            backgroundColor: ['#2F5FD7', '#3E68DA', '#4D72DE', '#5D7CE1', '#6D86E5', '#7C90E8'],
                            borderRadius: 12,
                            maxBarThickness: 50
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: labelColor,
                                    font: { weight: '600' }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: labelColor }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: gridColor },
                                ticks: {
                                    stepSize: 1,
                                    color: labelColor
                                }
                            }
                        }
                    }
                });
            }

            const roomCtx = document.getElementById('roomStatusDoughnutChart');
            if (roomCtx) {
                new Chart(roomCtx, {
                    type: 'doughnut',
                    data: {
                        labels: roomStatusLabels,
                        datasets: [{
                            data: roomStatusData,
                            backgroundColor: ['#20D3B3', '#F2B321', '#F0526D', '#94A3B8'],
                            borderColor: '#FFFFFF',
                            borderWidth: 6,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: labelColor,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 18,
                                    font: { weight: '600' }
                                }
                            }
                        }
                    }
                });
            }

            const paymentCtx = document.getElementById('paymentMethodDoughnutChart');
            if (paymentCtx) {
                new Chart(paymentCtx, {
                    type: 'doughnut',
                    data: {
                        labels: paymentMethodLabels,
                        datasets: [{
                            data: paymentMethodData,
                            backgroundColor: ['#20D3B3', '#2F5FD7', '#7B57E8'],
                            borderColor: '#FFFFFF',
                            borderWidth: 6,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: labelColor,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 18,
                                    font: { weight: '600' }
                                }
                            }
                        }
                    }
                });
            }

            const bookingStatusCtx = document.getElementById('bookingStatusPolarChart');
            if (bookingStatusCtx) {
                new Chart(bookingStatusCtx, {
                    type: 'polarArea',
                    data: {
                        labels: bookingStatusLabels,
                        datasets: [{
                            data: bookingStatusData,
                            backgroundColor: [
                                'rgba(242, 179, 33, 0.75)',
                                'rgba(47, 95, 215, 0.75)',
                                'rgba(32, 211, 179, 0.75)',
                                'rgba(148, 163, 184, 0.75)',
                                'rgba(240, 82, 109, 0.75)'
                            ],
                            borderColor: [
                                '#F2B321',
                                '#2F5FD7',
                                '#20D3B3',
                                '#94A3B8',
                                '#F0526D'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: labelColor,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 18,
                                    font: { weight: '600' }
                                }
                            }
                        },
                        scales: {
                            r: {
                                grid: { color: gridColor },
                                ticks: {
                                    backdropColor: 'transparent',
                                    color: labelColor
                                },
                                pointLabels: {
                                    color: labelColor,
                                    font: { size: 12, weight: '600' }
                                }
                            }
                        }
                    }
                });
            }

                        const dailyRevenueMixedCtx = document.getElementById('dailyRevenueMixedChart');
            if (dailyRevenueMixedCtx) {
                new Chart(dailyRevenueMixedCtx, {
                    data: {
                        labels: dailyRevenueLabels,
                        datasets: [
                            {
                                type: 'bar',
                                label: 'Doanh thu',
                                data: dailyRevenueData,
                                backgroundColor: 'rgba(32, 211, 179, 0.65)',
                                borderRadius: 10,
                                yAxisID: 'y',
                                maxBarThickness: 36
                            },
                            {
                                type: 'line',
                                label: 'Booking mới',
                                data: dailyBookingData,
                                borderColor: '#2F5FD7',
                                backgroundColor: 'rgba(47, 95, 215, 0.12)',
                                pointBackgroundColor: '#2F5FD7',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                tension: 0.4,
                                yAxisID: 'y1'
                            }
                        ]
                    },
                    options: {
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    color: labelColor,
                                    font: { weight: '600' }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: labelColor }
                            },
                            y: {
                                beginAtZero: true,
                                position: 'left',
                                grid: { color: gridColor },
                                ticks: {
                                    color: labelColor,
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN').format(value);
                                    }
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                grid: { drawOnChartArea: false },
                                ticks: {
                                    stepSize: 1,
                                    color: labelColor
                                }
                            }
                        }
                    }
                });
            }

            const topRoomTypeCtx = document.getElementById('topRoomTypeBarChart');
            if (topRoomTypeCtx) {
                new Chart(topRoomTypeCtx, {
                    type: 'bar',
                    data: {
                        labels: topRoomTypeLabels,
                        datasets: [{
                            label: 'Số booking',
                            data: topRoomTypeBookingData,
                            backgroundColor: ['#2F5FD7', '#20D3B3', '#7B57E8', '#F08A24', '#F0526D'],
                            borderRadius: 12,
                            borderSkipped: false
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: gridColor },
                                ticks: {
                                    color: labelColor,
                                    stepSize: 1
                                }
                            },
                            y: {
                                grid: { display: false },
                                ticks: {
                                    color: labelColor,
                                    font: { weight: '600' }
                                }
                            }
                        }
                    }
                });
            }

            animateCounters();
        });
    </script>
</x-app-layout>