<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo thanh toán</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        .header {
            margin-bottom: 18px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .summary {
            width: 100%;
            margin-bottom: 18px;
            border-collapse: collapse;
        }

        .summary td {
            width: 33.33%;
            border: 1px solid #dbe3ea;
            padding: 12px;
            vertical-align: top;
        }

        .summary-label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: bold;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
        }

        table.report th,
        table.report td {
            border: 1px solid #dbe3ea;
            padding: 8px 10px;
            vertical-align: top;
        }

        table.report th {
            background: #f3f6fa;
            text-align: left;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .muted {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">BÁO CÁO THANH TOÁN</div>
        <div class="subtitle">
            Thời gian xuất: {{ $generatedAt->format('d/m/Y H:i') }}
        </div>
    </div>

    <table class="summary">
        <tr>
            <td>
                <div class="summary-label">Tổng giao dịch</div>
                <div class="summary-value">{{ $totalPayments }}</div>
            </td>
            <td>
                <div class="summary-label">Tổng tiền đã thu</div>
                <div class="summary-value">{{ number_format($totalCollected, 0, ',', '.') }} VNĐ</div>
            </td>
            <td>
                <div class="summary-label">Ghi chú</div>
                <div class="muted">Dữ liệu bám theo bộ lọc hiện tại của danh sách thanh toán.</div>
            </td>
        </tr>
    </table>

    <table class="report">
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking</th>
                <th>Khách hàng</th>
                <th>Phòng</th>
                <th class="text-right">Số tiền</th>
                <th>Phương thức</th>
                <th>Trạng thái</th>
                <th>Thời gian thanh toán</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>#{{ $payment->booking->id ?? '—' }}</td>
                    <td>{{ $payment->booking->customer->full_name ?? '—' }}</td>
                    <td>{{ $payment->booking->room->room_number ?? '—' }}</td>
                    <td class="text-right">{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
                    <td>
                        @if($payment->payment_method === 'cash')
                            Tiền mặt
                        @elseif($payment->payment_method === 'transfer')
                            Chuyển khoản
                        @elseif($payment->payment_method === 'card')
                            Thẻ
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($payment->payment_status === 'paid')
                            Đã thanh toán
                        @elseif($payment->payment_status === 'refunded')
                            Hoàn tiền
                        @else
                            {{ $payment->payment_status }}
                        @endif
                    </td>
                    <td>{{ optional($payment->paid_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $payment->note ?: '—' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center;">Không có dữ liệu thanh toán phù hợp.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>