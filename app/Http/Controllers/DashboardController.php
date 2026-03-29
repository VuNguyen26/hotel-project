<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
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
            'bookingStatusData'
        ));
    }
}