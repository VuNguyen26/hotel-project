<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['customer', 'room.roomType', 'payments'])
            ->when($request->filled('keyword'), function ($query) use ($request) {
                $keyword = trim($request->keyword);

                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('customer', function ($customerQuery) use ($keyword) {
                        $customerQuery->where('full_name', 'like', '%' . $keyword . '%');
                    })->orWhereHas('room', function ($roomQuery) use ($keyword) {
                        $roomQuery->where('room_number', 'like', '%' . $keyword . '%');
                    });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->get();

        if ($request->filled('payment_filter')) {
            $paymentFilter = $request->payment_filter;

            $bookings = $bookings->filter(function ($booking) use ($paymentFilter) {
                $paidAmount = $booking->payments->where('payment_status', 'paid')->sum('amount');
                $remainingAmount = max($booking->total_price - $paidAmount, 0);

                if ($paymentFilter === 'unpaid') {
                    return $paidAmount <= 0;
                }

                if ($paymentFilter === 'partial') {
                    return $paidAmount > 0 && $remainingAmount > 0;
                }

                if ($paymentFilter === 'paid') {
                    return $booking->total_price > 0 && $remainingAmount <= 0;
                }

                return true;
            })->values();
        }

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

        $booking = Booking::create([
            'customer_id' => $request->customer_id,
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'total_price' => $totalPrice,
            'status' => $request->status,
        ]);

        $this->syncRoomStatus($room, $booking->status);

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

        $oldRoomId = $booking->room_id;

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

        if ($oldRoomId != $newRoom->id) {
            $oldRoom->update(['status' => 'available']);
        }

        $this->syncRoomStatus($newRoom, $booking->status);

        return redirect()->route('bookings.index')->with('success', 'Cập nhật đặt phòng thành công.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        $room = Room::find($booking->room_id);

        if ($room) {
            $this->syncRoomStatus($room, $booking->status);
        }

        return redirect()->route('bookings.index')->with('success', 'Cập nhật trạng thái booking thành công.');
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

    private function syncRoomStatus(Room $room, string $bookingStatus): void
    {
        if ($bookingStatus === 'confirmed') {
            $room->update(['status' => 'booked']);
        } elseif ($bookingStatus === 'checked_in') {
            $room->update(['status' => 'occupied']);
        } elseif (in_array($bookingStatus, ['checked_out', 'cancelled', 'pending'])) {
            $room->update(['status' => 'available']);
        }
    }
}