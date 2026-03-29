<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $monthStart = now()->copy()->startOfMonth();
        $monthEnd = now()->copy()->endOfMonth();

        $totalRoomTypes = RoomType::count();
        $totalRooms = Room::count();
        $totalCustomers = Customer::count();
        $totalBookings = Booking::count();

        $availableRooms = Room::where('status', 'available')->count();
        $bookedRooms = Room::where('status', 'booked')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        $totalCollected = (float) Payment::where('payment_status', 'paid')->sum('amount');
        $paidTransactions = Payment::where('payment_status', 'paid')->count();

        $occupancyRate = $totalRooms > 0
            ? round((($bookedRooms + $occupiedRooms) / $totalRooms) * 100)
            : 0;

        $latestBookings = Booking::with(['customer', 'room'])
            ->latest()
            ->take(5)
            ->get();

        $months = collect(range(5, 0))->map(function ($i) {
            return now()->copy()->subMonths($i)->startOfMonth();
        });

        $chartLabels = $months->map(function ($month) {
            return 'T' . $month->format('m/Y');
        })->values();

        $bookingChartData = $months->map(function ($month) {
            return Booking::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        })->values();

        $revenueChartData = $months->map(function ($month) {
            return (float) Payment::where('payment_status', 'paid')
                ->whereNotNull('paid_at')
                ->whereYear('paid_at', $month->year)
                ->whereMonth('paid_at', $month->month)
                ->sum('amount');
        })->values();

        $roomTypeSparkData = $months->map(function ($month) {
            return RoomType::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        })->values();

        $roomSparkData = $months->map(function ($month) {
            return Room::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        })->values();

        $customerSparkData = $months->map(function ($month) {
            return Customer::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        })->values();

        $bookingSparkData = $bookingChartData;

        $roomStatusLabels = ['Còn trống', 'Đã đặt', 'Đang sử dụng', 'Bảo trì'];
        $roomStatusData = [
            $availableRooms,
            $bookedRooms,
            $occupiedRooms,
            $maintenanceRooms,
        ];

        $paymentMethodLabels = ['Tiền mặt', 'Chuyển khoản', 'Thẻ'];
        $paymentMethodData = [
            (float) Payment::where('payment_status', 'paid')->where('payment_method', 'cash')->sum('amount'),
            (float) Payment::where('payment_status', 'paid')->where('payment_method', 'transfer')->sum('amount'),
            (float) Payment::where('payment_status', 'paid')->where('payment_method', 'card')->sum('amount'),
        ];

        $bookingStatusLabels = [
            'Chờ xác nhận',
            'Đã xác nhận',
            'Đã nhận phòng',
            'Đã trả phòng',
            'Đã hủy',
        ];

        $bookingStatusData = [
            Booking::where('status', 'pending')->count(),
            Booking::where('status', 'confirmed')->count(),
            Booking::where('status', 'checked_in')->count(),
            Booking::where('status', 'checked_out')->count(),
            Booking::where('status', 'cancelled')->count(),
        ];

        // ===== Thống kê nâng cao =====
        $revenueThisMonth = (float) Payment::where('payment_status', 'paid')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$monthStart, $monthEnd])
            ->sum('amount');

        $bookingsThisMonth = Booking::whereBetween('created_at', [$monthStart, $monthEnd])->count();

        $averageBookingValueThisMonth = (float) Booking::whereBetween('created_at', [$monthStart, $monthEnd])
            ->avg('total_price');

        $todayCheckIns = Booking::whereDate('check_in_date', $today)
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->count();

        $todayCheckOuts = Booking::whereDate('check_out_date', $today)
            ->whereIn('status', ['checked_in', 'checked_out'])
            ->count();

        $bookingsWithPaidAmount = Booking::with(['customer', 'room.roomType'])
            ->withSum([
                'payments as paid_amount' => function ($query) {
                    $query->where('payment_status', 'paid');
                }
            ], 'amount')
            ->get();

        $outstandingBalance = (float) $bookingsWithPaidAmount
            ->where('status', '!=', 'cancelled')
            ->sum(function ($booking) {
                return max((float) $booking->total_price - (float) ($booking->paid_amount ?? 0), 0);
            });

        $unpaidBookingCount = $bookingsWithPaidAmount
            ->filter(function ($booking) {
                $remaining = max((float) $booking->total_price - (float) ($booking->paid_amount ?? 0), 0);
                return $booking->status !== 'cancelled' && $remaining > 0;
            })
            ->count();

        $topOutstandingBookings = $bookingsWithPaidAmount
            ->map(function ($booking) {
                $booking->paid_amount_display = (float) ($booking->paid_amount ?? 0);
                $booking->remaining_amount = max((float) $booking->total_price - $booking->paid_amount_display, 0);
                return $booking;
            })
            ->filter(function ($booking) {
                return $booking->status !== 'cancelled' && $booking->remaining_amount > 0;
            })
            ->sortByDesc('remaining_amount')
            ->take(5)
            ->values();

        $topRoomTypes = RoomType::query()
            ->leftJoin('rooms', 'room_types.id', '=', 'rooms.room_type_id')
            ->leftJoin('bookings', function ($join) {
                $join->on('rooms.id', '=', 'bookings.room_id')
                    ->where('bookings.status', '!=', 'cancelled');
            })
            ->select(
                'room_types.id',
                'room_types.name',
                'room_types.price',
                DB::raw('COUNT(DISTINCT rooms.id) as rooms_count'),
                DB::raw('COUNT(bookings.id) as bookings_count'),
                DB::raw('COALESCE(SUM(bookings.total_price), 0) as revenue_total')
            )
            ->groupBy('room_types.id', 'room_types.name', 'room_types.price')
            ->orderByDesc('bookings_count')
            ->orderByDesc('revenue_total')
            ->limit(5)
            ->get();

        $topRoomTypeLabels = $topRoomTypes->pluck('name')->values();
        $topRoomTypeBookingData = $topRoomTypes->pluck('bookings_count')->map(fn ($value) => (int) $value)->values();

        $recentPayments = Payment::with(['booking.customer', 'booking.room'])
            ->where('payment_status', 'paid')
            ->latest('paid_at')
            ->take(5)
            ->get();

        $last14Days = collect(range(13, 0))->map(function ($i) use ($today) {
            return $today->copy()->subDays($i);
        });

        $dailyRevenueLabels = $last14Days->map(function ($day) {
            return $day->format('d/m');
        })->values();

        $dailyRevenueData = $last14Days->map(function ($day) {
            return (float) Payment::where('payment_status', 'paid')
                ->whereDate('paid_at', $day)
                ->sum('amount');
        })->values();

        $dailyBookingData = $last14Days->map(function ($day) {
            return Booking::whereDate('created_at', $day)->count();
        })->values();

        return view('dashboard', compact(
            'totalRoomTypes',
            'totalRooms',
            'totalCustomers',
            'totalBookings',
            'availableRooms',
            'bookedRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'totalCollected',
            'paidTransactions',
            'occupancyRate',
            'latestBookings',
            'chartLabels',
            'bookingChartData',
            'revenueChartData',
            'roomTypeSparkData',
            'roomSparkData',
            'customerSparkData',
            'bookingSparkData',
            'roomStatusLabels',
            'roomStatusData',
            'paymentMethodLabels',
            'paymentMethodData',
            'bookingStatusLabels',
            'bookingStatusData',

            'revenueThisMonth',
            'bookingsThisMonth',
            'averageBookingValueThisMonth',
            'todayCheckIns',
            'todayCheckOuts',
            'outstandingBalance',
            'unpaidBookingCount',
            'topOutstandingBookings',
            'topRoomTypes',
            'topRoomTypeLabels',
            'topRoomTypeBookingData',
            'recentPayments',
            'dailyRevenueLabels',
            'dailyRevenueData',
            'dailyBookingData'
        ));
    }
}