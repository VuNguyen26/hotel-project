<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(private Collection $bookings)
    {
    }

    public function collection(): Collection
    {
        return $this->bookings;
    }

    public function headings(): array
    {
        return [
            'Mã booking',
            'Khách hàng',
            'Số điện thoại',
            'Phòng',
            'Loại phòng',
            'Ngày nhận phòng',
            'Ngày trả phòng',
            'Người lớn',
            'Trẻ em',
            'Tổng tiền',
            'Đã thanh toán',
            'Còn lại',
            'Trạng thái',
            'Ngày tạo',
        ];
    }

    public function map($booking): array
    {
        $statusLabel = match ($booking->status) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'checked_in' => 'Đã nhận phòng',
            'checked_out' => 'Đã trả phòng',
            'cancelled' => 'Đã hủy',
            default => 'Không xác định',
        };

        return [
            $booking->id,
            $booking->customer->full_name ?? '—',
            $booking->customer->phone ?? '—',
            $booking->room->room_number ?? '—',
            $booking->room->roomType->name ?? '—',
            optional($booking->check_in_date)->format('d/m/Y'),
            optional($booking->check_out_date)->format('d/m/Y'),
            $booking->adults,
            $booking->children,
            number_format((float) $booking->total_price, 0, ',', '.') . ' VNĐ',
            number_format((float) ($booking->paid_amount_display ?? 0), 0, ',', '.') . ' VNĐ',
            number_format((float) ($booking->remaining_amount ?? 0), 0, ',', '.') . ' VNĐ',
            $statusLabel,
            optional($booking->created_at)->format('d/m/Y H:i'),
        ];
    }
}