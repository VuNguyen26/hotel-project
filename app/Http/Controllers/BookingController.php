<?php

namespace App\Http\Controllers;

use App\Exports\BookingsExport;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $allowedSorts = [
            'created_at' => 'created_at',
            'check_in_date' => 'check_in_date',
            'check_out_date' => 'check_out_date',
            'total_price' => 'total_price',
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $sortBy = array_key_exists($sortBy, $allowedSorts) ? $sortBy : 'created_at';

        $sortDir = $request->get('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $perPage = (int) $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;

        $bookings = $this->buildBookingsFilterQuery($request)
            ->orderBy($allowedSorts[$sortBy], $sortDir)
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('bookings.index', compact('bookings'));
    }

    public function exportExcel(Request $request)
    {
        $allowedSorts = [
            'created_at' => 'created_at',
            'check_in_date' => 'check_in_date',
            'check_out_date' => 'check_out_date',
            'total_price' => 'total_price',
        ];

        $sortBy = $request->get('sort_by', 'created_at');
        $sortBy = array_key_exists($sortBy, $allowedSorts) ? $allowedSorts[$sortBy] : 'created_at';

        $sortDir = $request->get('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $bookings = $this->buildBookingsFilterQuery($request)
            ->orderBy($sortBy, $sortDir)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($booking) {
                $paidAmount = (float) ($booking->paid_amount ?? 0);
                $booking->paid_amount_display = $paidAmount;
                $booking->remaining_amount = max((float) $booking->total_price - $paidAmount, 0);
                return $booking;
            });

        $fileName = 'bookings-report-' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new BookingsExport($bookings), $fileName);
    }

    public function create(Request $request)
    {
        $customers = Customer::orderBy('full_name')->get();
        $checkInDate = $request->query('check_in_date');
        $checkOutDate = $request->query('check_out_date');
        $rooms = $this->getAvailableRooms($checkInDate, $checkOutDate);

        return view('bookings.create', compact('customers', 'rooms', 'checkInDate', 'checkOutDate'));
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

        if ($room->status === 'maintenance') {
            return redirect()->back()->withInput()->withErrors([
                'room_id' => 'Phòng này đang bảo trì, không thể đặt.',
            ]);
        }

        if ($this->hasBookingConflict($room->id, $request->check_in_date, $request->check_out_date)) {
            return redirect()->back()->withInput()->withErrors([
                'room_id' => 'Phòng này đã có booking trùng trong khoảng ngày đã chọn.',
            ]);
        }

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = max($checkIn->diffInDays($checkOut), 1);
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

        $this->refreshRoomStatus($room);

        return redirect()->route('bookings.index')->with('success', 'Tạo đặt phòng thành công.');
    }

    public function show(Booking $booking)
    {
        $booking->load([
            'customer',
            'room.roomType',
            'payments' => function ($query) {
                $query->latest('paid_at')->latest('id');
            },
        ]);

        $nights = max(
            Carbon::parse($booking->check_in_date)->diffInDays(Carbon::parse($booking->check_out_date)),
            1
        );

        $paidAmount = $booking->payments
            ->where('payment_status', 'paid')
            ->sum('amount');

        $remainingAmount = max($booking->total_price - $paidAmount, 0);

        $paymentProgress = $booking->total_price > 0
            ? min(round(($paidAmount / $booking->total_price) * 100), 100)
            : 0;

        $invoiceCode = 'INV-' . $booking->created_at->format('Ymd') . '-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT);

        return view('bookings.show', compact(
            'booking',
            'nights',
            'paidAmount',
            'remainingAmount',
            'paymentProgress',
            'invoiceCode'
        ));
    }

    public function edit(Request $request, Booking $booking)
    {
        $customers = Customer::orderBy('full_name')->get();
        $checkInDate = $request->query('check_in_date', old('check_in_date', $booking->check_in_date));
        $checkOutDate = $request->query('check_out_date', old('check_out_date', $booking->check_out_date));
        $rooms = $this->getAvailableRooms($checkInDate, $checkOutDate, $booking->id);

        return view('bookings.edit', compact('booking', 'customers', 'rooms', 'checkInDate', 'checkOutDate'));
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

        if ($newRoom->status === 'maintenance') {
            return redirect()->back()->withInput()->withErrors([
                'room_id' => 'Phòng này đang bảo trì, không thể đặt.',
            ]);
        }

        if ($this->hasBookingConflict($newRoom->id, $request->check_in_date, $request->check_out_date, $booking->id)) {
            return redirect()->back()->withInput()->withErrors([
                'room_id' => 'Phòng này đã có booking trùng trong khoảng ngày đã chọn.',
            ]);
        }

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $nights = max($checkIn->diffInDays($checkOut), 1);
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

        $this->refreshRoomStatus($newRoom);

        if ($oldRoom->id !== $newRoom->id) {
            $this->refreshRoomStatus($oldRoom);
        }

        return redirect()->route('bookings.index')->with('success', 'Cập nhật đặt phòng thành công.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled',
        ]);

        if (
            in_array($request->status, ['pending', 'confirmed', 'checked_in'], true)
            && $this->hasBookingConflict($booking->room_id, $booking->check_in_date, $booking->check_out_date, $booking->id)
        ) {
            return redirect()
                ->route('bookings.index')
                ->with('error', 'Booking này đang bị trùng lịch với booking khác, không thể chuyển sang trạng thái giữ phòng.');
        }

        $booking->update([
            'status' => $request->status,
        ]);

        $room = Room::find($booking->room_id);

        if ($room) {
            $this->refreshRoomStatus($room);
        }

        return redirect()->route('bookings.index')->with('success', 'Cập nhật trạng thái booking thành công.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->payments()->exists()) {
            return redirect()
                ->route('bookings.index')
                ->with('error', 'Không thể xóa booking này vì đã có thanh toán phát sinh. Hãy giữ lại để đảm bảo lịch sử công nợ.');
        }

        $room = Room::find($booking->room_id);

        $booking->delete();

        if ($room) {
            $this->refreshRoomStatus($room);
        }

        return redirect()->route('bookings.index')->with('success', 'Xóa đặt phòng thành công.');
    }

    private function buildBookingsFilterQuery(Request $request)
    {
        return Booking::with(['customer', 'room.roomType'])
            ->withSum([
                'payments as paid_amount' => function ($query) {
                    $query->where('payment_status', 'paid');
                }
            ], 'amount')
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
            ->when($request->filled('payment_filter'), function ($query) use ($request) {
                if ($request->payment_filter === 'unpaid') {
                    $query->havingRaw('COALESCE(paid_amount, 0) = 0');
                } elseif ($request->payment_filter === 'partial') {
                    $query->havingRaw('COALESCE(paid_amount, 0) > 0 AND COALESCE(paid_amount, 0) < total_price');
                } elseif ($request->payment_filter === 'paid') {
                    $query->havingRaw('total_price > 0 AND COALESCE(paid_amount, 0) >= total_price');
                }
            });
    }

    private function getAvailableRooms(?string $checkInDate, ?string $checkOutDate, ?int $ignoreBookingId = null)
    {
        if (!$this->isValidDateRange($checkInDate, $checkOutDate)) {
            return collect();
        }

        return Room::with('roomType')
            ->where('status', '!=', 'maintenance')
            ->whereDoesntHave('bookings', function ($bookingQuery) use ($checkInDate, $checkOutDate, $ignoreBookingId) {
                $bookingQuery->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                    ->where('check_in_date', '<', $checkOutDate)
                    ->where('check_out_date', '>', $checkInDate)
                    ->when($ignoreBookingId, function ($q) use ($ignoreBookingId) {
                        $q->where('id', '!=', $ignoreBookingId);
                    });
            })
            ->orderBy('room_number')
            ->get();
    }

    private function hasBookingConflict(int $roomId, string $checkInDate, string $checkOutDate, ?int $ignoreBookingId = null): bool
    {
        return Booking::where('room_id', $roomId)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->where('check_in_date', '<', $checkOutDate)
            ->where('check_out_date', '>', $checkInDate)
            ->when($ignoreBookingId, function ($query) use ($ignoreBookingId) {
                $query->where('id', '!=', $ignoreBookingId);
            })
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