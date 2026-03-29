<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['booking.customer', 'booking.room'])
            ->latest()
            ->get();

        $totalCollected = Payment::where('payment_status', 'paid')->sum('amount');

        return view('payments.index', compact('payments', 'totalCollected'));
    }

    public function create(Request $request)
    {
        $bookings = Booking::with(['customer', 'room', 'payments'])
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->get();

        $payableBookings = $bookings->filter(function ($booking) {
            $paidAmount = $booking->payments->where('payment_status', 'paid')->sum('amount');
            return $paidAmount < $booking->total_price;
        })->values();

        $preselectedBookingId = $request->query('booking');

        return view('payments.create', compact('payableBookings', 'preselectedBookingId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,transfer,card',
            'note' => 'nullable|string',
        ], [
            'booking_id.required' => 'Vui lòng chọn booking.',
            'amount.required' => 'Vui lòng nhập số tiền thanh toán.',
            'amount.numeric' => 'Số tiền phải là số.',
            'amount.min' => 'Số tiền phải lớn hơn 0.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
        ]);

        $booking = Booking::with(['payments', 'customer', 'room'])->findOrFail($request->booking_id);

        if ($booking->status === 'cancelled') {
            return redirect()->back()->withInput()->withErrors([
                'booking_id' => 'Booking đã hủy, không thể thanh toán.',
            ]);
        }

        $paidAmount = $booking->payments->where('payment_status', 'paid')->sum('amount');
        $remainingAmount = max($booking->total_price - $paidAmount, 0);

        if ($remainingAmount <= 0) {
            return redirect()->back()->withInput()->withErrors([
                'booking_id' => 'Booking này đã thanh toán đủ.',
            ]);
        }

        if ($request->amount > $remainingAmount) {
            return redirect()->back()->withInput()->withErrors([
                'amount' => 'Số tiền thanh toán vượt quá số tiền còn lại (' . number_format($remainingAmount, 0, ',', '.') . ' VNĐ).',
            ]);
        }

        Payment::create([
            'booking_id' => $request->booking_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid',
            'paid_at' => now(),
            'note' => $request->note,
        ]);

        return redirect()->route('payments.index')->with('success', 'Ghi nhận thanh toán thành công.');
    }

    public function show(Payment $payment)
    {
        //
    }

    public function edit(Payment $payment)
    {
        //
    }

    public function update(Request $request, Payment $payment)
    {
        //
    }

    public function destroy(Payment $payment)
    {
        //
    }
}