<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicRoomController extends Controller
{
    public function index(Request $request)
    {
        $roomTypes = RoomType::orderBy('price')->get();

        $query = Room::with('roomType')
            ->where('status', '!=', 'maintenance');

        $checkInDate = $request->input('check_in_date');
        $checkOutDate = $request->input('check_out_date');

        $hasDateSearch = false;
        $dateSearchError = null;

        if ($checkInDate || $checkOutDate) {
            if (!$checkInDate || !$checkOutDate) {
                $dateSearchError = 'Vui lòng chọn đầy đủ ngày nhận phòng và ngày trả phòng.';
            } else {
                try {
                    $checkIn = Carbon::parse($checkInDate)->startOfDay();
                    $checkOut = Carbon::parse($checkOutDate)->startOfDay();

                    if ($checkOut->lte($checkIn)) {
                        $dateSearchError = 'Ngày trả phòng phải lớn hơn ngày nhận phòng.';
                    } else {
                        $hasDateSearch = true;

                        $query->whereDoesntHave('bookings', function ($bookingQuery) use ($checkInDate, $checkOutDate) {
                            $bookingQuery->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                                ->where('check_in_date', '<', $checkOutDate)
                                ->where('check_out_date', '>', $checkInDate);
                        });
                    }
                } catch (\Throwable $e) {
                    $dateSearchError = 'Ngày không hợp lệ. Vui lòng kiểm tra lại.';
                }
            }
        }

        if ($request->filled('room_type_id')) {
            $query->where('room_type_id', $request->room_type_id);
        }

        if ($request->filled('capacity')) {
            $capacity = (int) $request->capacity;

            $query->whereHas('roomType', function ($q) use ($capacity) {
                $q->where('capacity', '>=', $capacity);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sort = $request->get('sort', 'latest');

        switch ($sort) {
            case 'price_asc':
                $query->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
                    ->select('rooms.*')
                    ->orderBy('room_types.price', 'asc');
                break;

            case 'price_desc':
                $query->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
                    ->select('rooms.*')
                    ->orderBy('room_types.price', 'desc');
                break;

            case 'room_number_asc':
                $query->orderBy('room_number', 'asc');
                break;

            case 'room_number_desc':
                $query->orderBy('room_number', 'desc');
                break;

            default:
                $query->latest('rooms.id');
                break;
        }

        $rooms = $query->paginate(9)->withQueryString();

        return view('user.rooms.index', compact(
            'rooms',
            'roomTypes',
            'hasDateSearch',
            'dateSearchError',
            'checkInDate',
            'checkOutDate'
        ));
    }

    public function show(Room $room)
    {
        if ($room->status === 'maintenance') {
            abort(404);
        }

        $room->load('roomType');

        $relatedRooms = Room::with('roomType')
            ->where('status', '!=', 'maintenance')
            ->where('room_type_id', $room->room_type_id)
            ->where('id', '!=', $room->id)
            ->latest('id')
            ->limit(3)
            ->get();

        return view('user.rooms.show', compact('room', 'relatedRooms'));
    }
}