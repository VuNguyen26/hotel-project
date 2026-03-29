<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\Room;
use App\Models\Customer;
use App\Models\Booking;

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

        $latestBookings = Booking::with(['customer', 'room'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalRoomTypes',
            'totalRooms',
            'totalCustomers',
            'totalBookings',
            'availableRooms',
            'bookedRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'latestBookings'
        ));
    }
}