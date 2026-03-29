<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::latest()->get();
        return view('room_types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('room_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ], [
            'name.required' => 'Vui lòng nhập tên loại phòng.',
            'price.required' => 'Vui lòng nhập giá phòng.',
            'price.numeric' => 'Giá phòng phải là số.',
            'capacity.required' => 'Vui lòng nhập sức chứa.',
            'capacity.integer' => 'Sức chứa phải là số nguyên.',
            'capacity.min' => 'Sức chứa phải lớn hơn hoặc bằng 1.',
        ]);

        RoomType::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('room-types.index')->with('success', 'Thêm loại phòng thành công.');
    }

    public function show(RoomType $roomType)
    {
        //
    }

    public function edit(RoomType $roomType)
    {
        return view('room_types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ], [
            'name.required' => 'Vui lòng nhập tên loại phòng.',
            'price.required' => 'Vui lòng nhập giá phòng.',
            'price.numeric' => 'Giá phòng phải là số.',
            'capacity.required' => 'Vui lòng nhập sức chứa.',
            'capacity.integer' => 'Sức chứa phải là số nguyên.',
            'capacity.min' => 'Sức chứa phải lớn hơn hoặc bằng 1.',
        ]);

        $roomType->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('room-types.index')->with('success', 'Cập nhật loại phòng thành công.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomCount = $roomType->rooms()->count();

        if ($roomCount > 0) {
            return redirect()
                ->route('room-types.index')
                ->with('error', 'Không thể xóa loại phòng này vì đang có ' . $roomCount . ' phòng thuộc loại này.');
        }

        $roomType->delete();

        return redirect()->route('room-types.index')->with('success', 'Xóa loại phòng thành công.');
    }
}