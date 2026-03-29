<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $allowedSorts = [
            'paid_at' => 'paid_at',
            'amount' => 'amount',
            'created_at' => 'created_at',
        ];

        $sortBy = $request->get('sort_by', 'paid_at');
        $sortBy = array_key_exists($sortBy, $allowedSorts) ? $sortBy : 'paid_at';

        $sortDir = $request->get('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $perPage = (int) $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 50, 100], true) ? $perPage : 10;

        $baseQuery = $this->buildPaymentsFilterQuery($request);

        $totalPayments = (clone $baseQuery)->count();
        $totalCollected = (clone $baseQuery)
            ->where('payment_status', 'paid')
            ->sum('amount');

        $payments = (clone $baseQuery)
            ->orderBy($allowedSorts[$sortBy], $sortDir)
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('payments.index', compact('payments', 'totalCollected', 'totalPayments'));
    }

    public function exportPdf(Request $request)
    {
        $allowedSorts = [
            'paid_at' => 'paid_at',
            'amount' => 'amount',
            'created_at' => 'created_at',
        ];

        $sortBy = $request->get('sort_by', 'paid_at');
        $sortBy = array_key_exists($sortBy, $allowedSorts) ? $allowedSorts[$sortBy] : 'paid_at';

        $sortDir = $request->get('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $baseQuery = $this->buildPaymentsFilterQuery($request);

        $payments = (clone $baseQuery)
            ->orderBy($sortBy, $sortDir)
            ->orderBy('id', 'desc')
            ->get();

        $totalPayments = $payments->count();
        $totalCollected = $payments
            ->where('payment_status', 'paid')
            ->sum('amount');

        $generatedAt = now();

        $pdf = Pdf::loadView('payments.export-pdf', compact(
            'payments',
            'totalPayments',
            'totalCollected',
            'generatedAt'
        ))->setPaper('a4', 'landscape');

        $fileName = 'payments-report-' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($fileName);
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

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Ghi nhận thanh toán thành công.');
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

    private function buildPaymentsFilterQuery(Request $request)
    {
        return Payment::with(['booking.customer', 'booking.room'])
            ->when($request->filled('keyword'), function ($query) use ($request) {
                $keyword = trim($request->keyword);

                $query->where(function ($q) use ($keyword) {
                    $q->where('note', 'like', '%' . $keyword . '%')
                        ->orWhereHas('booking.customer', function ($customerQuery) use ($keyword) {
                            $customerQuery->where('full_name', 'like', '%' . $keyword . '%');
                        })
                        ->orWhereHas('booking.room', function ($roomQuery) use ($keyword) {
                            $roomQuery->where('room_number', 'like', '%' . $keyword . '%');
                        });

                    if (is_numeric($keyword)) {
                        $q->orWhere('booking_id', (int) $keyword);
                    }
                });
            })
            ->when($request->filled('payment_method'), function ($query) use ($request) {
                $query->where('payment_method', $request->payment_method);
            })
            ->when($request->filled('payment_status'), function ($query) use ($request) {
                $query->where('payment_status', $request->payment_status);
            });
    }
}