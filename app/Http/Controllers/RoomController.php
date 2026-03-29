<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $roomTypes = RoomType::orderBy('name')->get();

        $rooms = Room::with('roomType')
            ->when($request->filled('keyword'), function ($query) use ($request) {
                $keyword = trim($request->keyword);

                $query->where(function ($q) use ($keyword) {
                    $q->where('room_number', 'like', '%' . $keyword . '%')
                      ->orWhere('note', 'like', '%' . $keyword . '%');
                });
            })
            ->when($request->filled('room_type_id'), function ($query) use ($request) {
                $query->where('room_type_id', $request->room_type_id);
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->get();

        return view('rooms.index', compact('rooms', 'roomTypes'));
    }

    public function create()
    {
        $roomTypes = RoomType::orderBy('name')->get();
        return view('rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:50|unique:rooms,room_number',
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'nullable|integer|min:1',
            'status' => 'required|in:available,booked,occupied,maintenance',
            'note' => 'nullable|string',
        ], [
            'room_number.required' => 'Vui lòng nhập số phòng.',
            'room_number.unique' => 'Số phòng đã tồn tại.',
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng không hợp lệ.',
            'floor.integer' => 'Tầng phải là số nguyên.',
            'floor.min' => 'Tầng phải lớn hơn hoặc bằng 1.',
            'status.required' => 'Vui lòng chọn trạng thái phòng.',
        ]);

        Room::create([
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'floor' => $request->floor,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Thêm phòng thành công.');
    }

    public function show(Room $room)
    {
        //
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::orderBy('name')->get();
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|string|max:50|unique:rooms,room_number,' . $room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'nullable|integer|min:1',
            'status' => 'required|in:available,booked,occupied,maintenance',
            'note' => 'nullable|string',
        ], [
            'room_number.required' => 'Vui lòng nhập số phòng.',
            'room_number.unique' => 'Số phòng đã tồn tại.',
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng không hợp lệ.',
            'floor.integer' => 'Tầng phải là số nguyên.',
            'floor.min' => 'Tầng phải lớn hơn hoặc bằng 1.',
            'status.required' => 'Vui lòng chọn trạng thái phòng.',
        ]);

        $room->update([
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'floor' => $request->floor,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Cập nhật phòng thành công.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Xóa phòng thành công.');
    }
}