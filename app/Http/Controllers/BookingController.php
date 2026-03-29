<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['customer', 'room.roomType'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $customers = Customer::orderBy('full_name')->get();
        $rooms = Room::with('roomType')
            ->where('status', 'available')
            ->orderBy('room_number')
            ->get();

        return view('bookings.create', compact('customers', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
        ], [
            'customer_id.required' => 'Vui lòng chọn khách hàng.',
            'room_id.required' => 'Vui lòng chọn phòng.',
            'check_in_date.required' => 'Vui lòng chọn ngày nhận phòng.',
            'check_out_date.required' => 'Vui lòng chọn ngày trả phòng.',
            'check_out_date.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',
            'adults.required' => 'Vui lòng nhập số người lớn.',
            'adults.min' => 'Số người lớn phải lớn hơn hoặc bằng 1.',
        ]);

        $room = Room::with('roomType')->findOrFail($request->room_id);

        if ($room->status !== 'available') {
            return redirect()->back()->withInput()->withErrors([
                'room_id' => 'Phòng này hiện không còn trống.',
            ]);
        }

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $room->roomType->price;

        Booking::create([
            'customer_id' => $request->customer_id,
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        if (in_array($request->status, ['confirmed', 'checked_in'])) {
            $room->update([
                'status' => $request->status === 'checked_in' ? 'occupied' : 'booked',
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Tạo đặt phòng thành công.');
    }

    public function show(Booking $booking)
    {
        //
    }

    public function edit(Booking $booking)
    {
        $customers = Customer::orderBy('full_name')->get();
        $rooms = Room::with('roomType')->orderBy('room_number')->get();

        return view('bookings.edit', compact('booking', 'customers', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
        ], [
            'customer_id.required' => 'Vui lòng chọn khách hàng.',
            'room_id.required' => 'Vui lòng chọn phòng.',
            'check_in_date.required' => 'Vui lòng chọn ngày nhận phòng.',
            'check_out_date.required' => 'Vui lòng chọn ngày trả phòng.',
            'check_out_date.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',
            'adults.required' => 'Vui lòng nhập số người lớn.',
            'adults.min' => 'Số người lớn phải lớn hơn hoặc bằng 1.',
        ]);

        $oldRoom = Room::findOrFail($booking->room_id);
        $newRoom = Room::with('roomType')->findOrFail($request->room_id);

        if ($booking->room_id != $request->room_id && $newRoom->status !== 'available') {
            return redirect()->back()->withInput()->withErrors([
                'room_id' => 'Phòng mới chọn hiện không còn trống.',
            ]);
        }

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $newRoom->roomType->price;

        $booking->update([
            'customer_id' => $request->customer_id,
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        if ($booking->room_id != $oldRoom->id) {
            $oldRoom->update(['status' => 'available']);
        }

        if ($request->status === 'confirmed') {
            $newRoom->update(['status' => 'booked']);
        } elseif ($request->status === 'checked_in') {
            $newRoom->update(['status' => 'occupied']);
        } elseif (in_array($request->status, ['checked_out', 'cancelled', 'pending'])) {
            $newRoom->update(['status' => 'available']);
        }

        return redirect()->route('bookings.index')->with('success', 'Cập nhật đặt phòng thành công.');
    }

    public function destroy(Booking $booking)
    {
        $room = Room::find($booking->room_id);

        if ($room) {
            $room->update(['status' => 'available']);
        }

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Xóa đặt phòng thành công.');
    }
}