<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicBookingController extends Controller
{
    public function create(Request $request, Room $room)
    {
        if ($room->status === 'maintenance') {
            abort(404);
        }

        $room->load('roomType');

        $checkInDate = $request->query('check_in_date');
        $checkOutDate = $request->query('check_out_date');

        $nights = null;
        $estimatedTotal = null;

        if ($this->isValidDateRange($checkInDate, $checkOutDate)) {
            $checkIn = Carbon::parse($checkInDate);
            $checkOut = Carbon::parse($checkOutDate);
            $nights = max($checkIn->diffInDays($checkOut), 1);
            $estimatedTotal = $nights * ($room->roomType->price ?? 0);
        }

        return view('user.bookings.create', compact(
            'room',
            'checkInDate',
            'checkOutDate',
            'nights',
            'estimatedTotal'
        ));
    }

    public function store(Request $request, Room $room)
    {
        if ($room->status === 'maintenance') {
            abort(404);
        }

        $room->load('roomType');

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required_without:email|nullable|string|max:20',
            'email' => 'required_without:phone|nullable|email|max:255',
            'identity_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
        ], [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'phone.required_without' => 'Vui lòng nhập số điện thoại hoặc email.',
            'email.required_without' => 'Vui lòng nhập email hoặc số điện thoại.',
            'email.email' => 'Email không đúng định dạng.',
            'check_in_date.required' => 'Vui lòng chọn ngày nhận phòng.',
            'check_in_date.after_or_equal' => 'Ngày nhận phòng phải từ hôm nay trở đi.',
            'check_out_date.required' => 'Vui lòng chọn ngày trả phòng.',
            'check_out_date.after' => 'Ngày trả phòng phải sau ngày nhận phòng.',
            'adults.required' => 'Vui lòng nhập số người lớn.',
            'adults.min' => 'Số người lớn phải lớn hơn hoặc bằng 1.',
            'children.min' => 'Số trẻ em không được âm.',
        ]);

        $children = (int) ($validated['children'] ?? 0);
        $totalGuests = (int) $validated['adults'] + $children;
        $roomCapacity = (int) ($room->roomType->capacity ?? 0);

        if ($totalGuests > $roomCapacity) {
            return back()->withInput()->withErrors([
                'adults' => 'Tổng số khách vượt quá sức chứa của phòng này.',
            ]);
        }

        if ($this->hasBookingConflict($room->id, $validated['check_in_date'], $validated['check_out_date'])) {
            return back()->withInput()->withErrors([
                'check_in_date' => 'Phòng này đã có booking trùng trong khoảng ngày bạn chọn. Vui lòng chọn ngày khác hoặc chọn phòng khác.',
            ]);
        }

        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = max($checkIn->diffInDays($checkOut), 1);
        $totalPrice = $nights * ($room->roomType->price ?? 0);

        $customer = $this->findOrCreateCustomer($request);

        $booking = Booking::create([
            'customer_id' => $customer->id,
            'room_id' => $room->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'adults' => (int) $validated['adults'],
            'children' => $children,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        $this->refreshRoomStatus($room);

        $summary = [
            'booking_id' => $booking->id,
            'booking_code' => 'BK-' . $booking->created_at->format('Ymd') . '-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'customer_name' => $customer->full_name,
            'customer_phone' => $customer->phone,
            'customer_email' => $customer->email,
            'room_number' => $room->room_number,
            'room_type' => $room->roomType?->name,
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date,
            'adults' => $booking->adults,
            'children' => $booking->children,
            'nights' => $nights,
            'total_price' => $booking->total_price,
            'status' => $booking->status,
        ];

        return redirect()
            ->route('public.bookings.success')
            ->with('booking_success', $summary);
    }

    public function success()
    {
        if (!session()->has('booking_success')) {
            return redirect()->route('home');
        }

        $summary = session('booking_success');

        return view('user.bookings.success', compact('summary'));
    }

    private function findOrCreateCustomer(Request $request): Customer
    {
        $email = $request->filled('email')
            ? strtolower(trim((string) $request->email))
            : null;

        $phone = $request->filled('phone')
            ? trim((string) $request->phone)
            : null;

        $customer = null;

        if ($email) {
            $customer = Customer::where('email', $email)->first();
        }

        if (!$customer && $phone) {
            $customer = Customer::where('phone', $phone)->first();
        }

        if (!$customer) {
            return Customer::create([
                'full_name' => trim((string) $request->full_name),
                'phone' => $phone,
                'email' => $email,
                'identity_number' => $request->filled('identity_number') ? trim((string) $request->identity_number) : null,
                'address' => $request->filled('address') ? trim((string) $request->address) : null,
            ]);
        }

        $customer->full_name = trim((string) $request->full_name);

        if ($phone) {
            $customer->phone = $phone;
        }

        if ($email) {
            $customer->email = $email;
        }

        if ($request->filled('identity_number')) {
            $customer->identity_number = trim((string) $request->identity_number);
        }

        if ($request->filled('address')) {
            $customer->address = trim((string) $request->address);
        }

        $customer->save();

        return $customer;
    }

    private function hasBookingConflict(int $roomId, string $checkInDate, string $checkOutDate): bool
    {
        return Booking::where('room_id', $roomId)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->where('check_in_date', '<', $checkOutDate)
            ->where('check_out_date', '>', $checkInDate)
            ->exists();
    }

    private function isValidDateRange(?string $checkInDate, ?string $checkOutDate): bool
    {
        if (!$checkInDate || !$checkOutDate) {
            return false;
        }

        return Carbon::parse($checkOutDate)->gt(Carbon::parse($checkInDate));
    }

    private function refreshRoomStatus(Room $room): void
    {
        if ($room->status === 'maintenance') {
            return;
        }

        $room->loadMissing('bookings');

        $hasCheckedInBooking = $room->bookings
            ->where('status', 'checked_in')
            ->isNotEmpty();

        if ($hasCheckedInBooking) {
            $room->update(['status' => 'occupied']);
            return;
        }

        $today = now()->toDateString();

        $hasReservedBooking = $room->bookings
            ->whereIn('status', ['pending', 'confirmed'])
            ->filter(function ($booking) use ($today) {
                return $booking->check_out_date >= $today;
            })
            ->isNotEmpty();

        $room->update([
            'status' => $hasReservedBooking ? 'booked' : 'available',
        ]);
    }
}