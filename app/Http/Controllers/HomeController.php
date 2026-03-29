<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;

class HomeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::withCount('rooms')
            ->orderBy('price')
            ->get();

        $featuredRooms = Room::with('roomType')
            ->where('status', '!=', 'maintenance')
            ->whereHas('roomType')
            ->latest('id')
            ->take(6)
            ->get();

        $stats = [
            'room_types' => RoomType::count(),
            'rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'bookings' => Booking::count(),
        ];

        return view('user.home', compact('roomTypes', 'featuredRooms', 'stats'));
    }
}