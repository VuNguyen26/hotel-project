<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                    Phiếu thanh toán
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Mẫu phiếu in A4 gọn, chuyên nghiệp, dễ trình bày khi demo.
                </p>
            </div>

            <div class="no-print flex items-center gap-3">
                @if($booking->status !== 'cancelled' && $remainingAmount > 0)
                    <a href="{{ route('payments.create', ['booking' => $booking->id]) }}"
                       class="rounded-xl bg-violet-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-violet-700">
                        + Ghi nhận thanh toán
                    </a>
                @endif

                <button type="button"
                        onclick="window.print()"
                        class="rounded-xl bg-slate-800 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-slate-900">
                    In phiếu
                </button>

                <a href="{{ route('bookings.index') }}"
                   class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Quay lại
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $statusLabel = match($booking->status) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'checked_in' => 'Đã nhận phòng',
            'checked_out' => 'Đã trả phòng',
            'cancelled' => 'Đã hủy',
            default => 'Không xác định',
        };

        $paymentLabel = 'Chưa thanh toán';
        if ($paidAmount >= $booking->total_price && $booking->total_price > 0) {
            $paymentLabel = 'Đã thanh toán đủ';
        } elseif ($paidAmount > 0) {
            $paymentLabel = 'Thanh toán một phần';
        }

        $roomPrice = $booking->room->roomType->price ?? 0;
    @endphp

    <style>
        .invoice-shell {
            max-width: 900px;
            margin: 0 auto;
        }

        .invoice-paper,
            .invoice-paper * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

        .invoice-paper {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .invoice-head {
            padding: 32px;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(to bottom, #ffffff, #f8fafc);
        }

        .invoice-section {
            padding: 24px 32px;
            border-bottom: 1px solid #e2e8f0;
        }

        .invoice-section:last-child {
            border-bottom: none;
        }

        .invoice-title {
            font-size: 28px;
            line-height: 1.15;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .invoice-subtitle {
            margin-top: 6px;
            font-size: 14px;
            color: #64748b;
        }

        .invoice-code {
            font-size: 24px;
            line-height: 1.15;
            font-weight: 800;
            color: #111827;
            margin-top: 8px;
        }

        .meta-grid,
        .info-grid,
        .summary-grid {
            display: grid;
            gap: 16px;
        }

        .meta-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .summary-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .meta-box,
        .info-box,
        .summary-box {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            padding: 16px 18px;
        }

        .label-sm {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .value-lg {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .value-md {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            line-height: 1.5;
        }

        .value-sm {
            font-size: 14px;
            color: #475569;
            line-height: 1.6;
        }

        .section-heading {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 14px 0;
        }

        .kv-table,
        .money-table,
        .payment-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kv-table td {
            padding: 8px 0;
            vertical-align: top;
            border-bottom: 1px dashed #e2e8f0;
        }

        .kv-table tr:last-child td {
            border-bottom: none;
        }

        .kv-key {
            width: 42%;
            font-size: 14px;
            color: #64748b;
        }

        .kv-val {
            font-size: 14px;
            color: #0f172a;
            font-weight: 600;
            text-align: right;
        }

        .money-table th,
        .money-table td,
        .payment-table th,
        .payment-table td {
            padding: 11px 12px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            font-size: 14px;
        }

        .money-table th,
        .payment-table th {
            background: #f8fafc;
            color: #334155;
            font-weight: 700;
        }

        .money-table td:last-child,
        .money-table th:last-child {
            text-align: right;
        }

        .payment-table td:nth-child(3),
        .payment-table th:nth-child(3) {
            text-align: right;
        }

        .money-strong {
            font-weight: 800;
            color: #0f172a;
        }

        .money-paid {
            color: #059669;
            font-weight: 800;
        }

        .money-remain {
            color: #dc2626;
            font-weight: 800;
        }

        .money-done {
            color: #2563eb;
            font-weight: 800;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-dark {
            background: #e2e8f0;
            color: #0f172a;
        }

        .status-green {
            background: #dcfce7;
            color: #166534;
        }

        .status-amber {
            background: #fef3c7;
            color: #92400e;
        }

        .status-red {
            background: #fee2e2;
            color: #b91c1c;
        }

        .progress-wrap {
            margin-top: 12px;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            overflow: hidden;
            border-radius: 9999px;
            background: #e2e8f0;
        }

        .progress-fill {
            height: 100%;
            background: #7c3aed;
            border-radius: 9999px;
        }

        .signature-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
            margin-top: 28px;
        }

        .signature-box {
            text-align: center;
            padding-top: 8px;
        }

        .signature-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        .signature-line {
            margin-top: 64px;
            border-top: 1px solid #94a3b8;
            height: 1px;
        }

        .signature-note {
            margin-top: 8px;
            font-size: 12px;
            color: #64748b;
        }

        .invoice-note {
            margin-top: 10px;
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
        }

        @media screen and (max-width: 768px) {
        .meta-grid,
        .info-grid,
        .summary-grid,
        .signature-grid {
            grid-template-columns: 1fr;
        }

        .invoice-head,
        .invoice-section {
            padding: 20px;
        }

        .invoice-title {
            font-size: 22px;
        }

        .invoice-code {
            font-size: 20px;
        }
    }

        @media print {
            @page {
                size: A4;
                margin: 12mm;
            }

            html, body {
                background: #ffffff !important;
            }

            .no-print {
                display: none !important;
            }

            .invoice-shell {
                max-width: 100% !important;
            }

            .invoice-paper {
                border: none !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                overflow: visible !important;
            }

            .invoice-head {
                padding: 0 0 16px 0 !important;
                background: #ffffff !important;
            }

            .invoice-section {
                padding: 14px 0 !important;
            }

            .meta-box,
            .info-box,
            .summary-box {
                break-inside: avoid;
                page-break-inside: avoid;
                border-radius: 12px !important;
                padding: 12px 14px !important;
            }

            .invoice-section,
            .meta-box,
            .info-box,
            .summary-box,
            .payment-table,
            .money-table,
            .signature-grid {
                break-inside: avoid;
                page-break-inside: avoid;
            }

            .invoice-title {
                font-size: 22px !important;
            }

            .invoice-code {
                font-size: 18px !important;
            }

            .value-lg {
                font-size: 16px !important;
            }

            .section-heading {
                font-size: 14px !important;
                margin-bottom: 10px !important;
            }

            .money-table th,
            .money-table td,
            .payment-table th,
            .payment-table td {
                font-size: 12px !important;
                padding: 8px 10px !important;
            }

            .kv-key,
            .kv-val,
            .value-sm,
            .value-md {
                font-size: 12px !important;
            }

            .signature-line {
                margin-top: 46px !important;
            }

            .meta-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }

            .info-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }

            .summary-grid {
                display: grid !important;
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                gap: 12px !important;
            }

            .signature-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 20px !important;
            }

            .progress-bar {
                background: #e2e8f0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .progress-fill {
                background: #7c3aed !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .status-chip {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

    <div class="py-8">
        <div class="invoice-shell px-4 sm:px-6 lg:px-0">

            @if(session('success'))
                <div class="no-print mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="invoice-paper">
                <div class="invoice-head">
                    <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Hotel Management System</p>
                            <h1 class="invoice-title">PHIẾU THANH TOÁN</h1>
                            <p class="invoice-subtitle">
                                Theo dõi chi tiết đặt phòng, công nợ và lịch sử giao dịch.
                            </p>
                            <div class="invoice-code">{{ $invoiceCode }}</div>
                        </div>

                        <div class="md:min-w-[280px]">
                            <div class="meta-grid">
                                <div class="meta-box">
                                    <span class="label-sm">Mã booking</span>
                                    <div class="value-lg">#{{ $booking->id }}</div>
                                </div>

                                <div class="meta-box">
                                    <span class="label-sm">Trạng thái</span>
                                    <div class="mt-1">
                                        @if($booking->status === 'cancelled')
                                            <span class="status-chip status-red">{{ $statusLabel }}</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="status-chip status-amber">{{ $statusLabel }}</span>
                                        @else
                                            <span class="status-chip status-dark">{{ $statusLabel }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="meta-box">
                                    <span class="label-sm">Ngày tạo phiếu</span>
                                    <div class="value-md">{{ $booking->created_at->format('d/m/Y H:i') }}</div>
                                </div>

                                <div class="meta-box">
                                    <span class="label-sm">Tình trạng thanh toán</span>
                                    <div class="mt-1">
                                        @if($remainingAmount <= 0 && $booking->total_price > 0)
                                            <span class="status-chip status-green">{{ $paymentLabel }}</span>
                                        @elseif($paidAmount > 0)
                                            <span class="status-chip status-amber">{{ $paymentLabel }}</span>
                                        @else
                                            <span class="status-chip status-red">{{ $paymentLabel }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="invoice-section">
                    <div class="info-grid">
                        <div class="info-box">
                            <h3 class="section-heading">Thông tin khách hàng</h3>

                            <table class="kv-table">
                                <tr>
                                    <td class="kv-key">Họ tên</td>
                                    <td class="kv-val">{{ $booking->customer->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="kv-key">Số điện thoại</td>
                                    <td class="kv-val">{{ $booking->customer->phone ?: 'Chưa có' }}</td>
                                </tr>
                                <tr>
                                    <td class="kv-key">Email</td>
                                    <td class="kv-val">{{ $booking->customer->email ?: 'Chưa có' }}</td>
                                </tr>
                                <tr>
                                    <td class="kv-key">CCCD / CMND</td>
                                    <td class="kv-val">{{ $booking->customer->identity_number ?: 'Chưa có' }}</td>
                                </tr>
                                <tr>
                                    <td class="kv-key">Địa chỉ</td>
                                    <td class="kv-val">{{ $booking->customer->address ?: 'Chưa có' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="info-box">
                            <h3 class="section-heading">Thông tin lưu trú</h3>

                            <table class="kv-table">
                                <tr>
                                    <td class="kv-key">Phòng</td>
                                    <td class="kv-val">Phòng {{ $booking->room->room_number }}</td>
                                </tr>
                                <tr>
                                    <td class="kv-key">Loại phòng</td>
                                    <td class="kv-val">{{ $booking->room->roomType->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="kv-key">Ngày nhận phòng</td>
                                    <td class="kv-val">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="kv-key">Ngày trả phòng</td>
                                    <td class="kv-val">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="kv-key">Số đêm</td>
                                    <td class="kv-val">{{ $nights }} đêm</td>
                                </tr>
                                <tr>
                                    <td class="kv-key">Số khách</td>
                                    <td class="kv-val">{{ $booking->adults }} người lớn, {{ $booking->children }} trẻ em</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="invoice-section">
                    <div class="summary-grid">
                        <div class="summary-box">
                            <span class="label-sm">Tổng booking</span>
                            <div class="value-lg">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</div>
                            <div class="value-sm mt-1">Tiền phòng của toàn bộ kỳ lưu trú.</div>
                        </div>

                        <div class="summary-box">
                            <span class="label-sm">Đã thanh toán</span>
                            <div class="value-lg" style="color:#059669;">{{ number_format($paidAmount, 0, ',', '.') }} VNĐ</div>
                            <div class="value-sm mt-1">Tổng tiền đã ghi nhận thành công.</div>
                        </div>

                        <div class="summary-box">
                            <span class="label-sm">Còn lại</span>
                            <div class="value-lg" style="color: {{ $remainingAmount > 0 ? '#dc2626' : '#2563eb' }};">
                                {{ number_format($remainingAmount, 0, ',', '.') }} VNĐ
                            </div>
                            <div class="value-sm mt-1">
                                {{ $remainingAmount > 0 ? 'Khoản còn phải thu.' : 'Đã tất toán đầy đủ.' }}
                            </div>
                        </div>
                    </div>

                    <div class="progress-wrap">
                        <div class="flex items-center justify-between text-sm font-medium text-slate-600">
                            <span>Tiến độ thanh toán</span>
                            <span>{{ $paymentProgress }}%</span>
                        </div>

                        <div class="progress-bar mt-2">
                            <div class="progress-fill" style="width: {{ $paymentProgress }}%;"></div>
                        </div>
                    </div>
                </div>

                <div class="invoice-section">
                    <h3 class="section-heading">Chi tiết tính tiền</h3>

                    <table class="money-table">
                        <thead>
                            <tr>
                                <th>Nội dung</th>
                                <th>Giá trị</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Đơn giá phòng / đêm</td>
                                <td>{{ number_format($roomPrice, 0, ',', '.') }} VNĐ</td>
                            </tr>
                            <tr>
                                <td>Số đêm lưu trú</td>
                                <td>{{ $nights }} đêm</td>
                            </tr>
                            <tr>
                                <td class="money-strong">Tổng tiền booking</td>
                                <td class="money-strong">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</td>
                            </tr>
                            <tr>
                                <td class="money-paid">Đã thanh toán</td>
                                <td class="money-paid">- {{ number_format($paidAmount, 0, ',', '.') }} VNĐ</td>
                            </tr>
                            <tr>
                                <td class="{{ $remainingAmount > 0 ? 'money-remain' : 'money-done' }}">
                                    {{ $remainingAmount > 0 ? 'Số tiền còn lại' : 'Công nợ còn lại' }}
                                </td>
                                <td class="{{ $remainingAmount > 0 ? 'money-remain' : 'money-done' }}">
                                    {{ number_format($remainingAmount, 0, ',', '.') }} VNĐ
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="invoice-note">
                        Ghi chú: Phiếu này phản ánh tình trạng thanh toán của booking tại thời điểm in.
                        Các giao dịch phát sinh sau thời điểm này có thể làm thay đổi số dư còn lại.
                    </p>
                </div>

                <div class="invoice-section">
                    <h3 class="section-heading">Lịch sử thanh toán</h3>

                    @if($booking->payments->count() > 0)
                        <table class="payment-table">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">ID</th>
                                    <th>Thời gian</th>
                                    <th style="width: 170px;">Số tiền</th>
                                    <th>Phương thức</th>
                                    <th>Trạng thái</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ optional($payment->paid_at)->format('d/m/Y H:i') }}</td>
                                        <td class="money-strong">{{ number_format($payment->amount, 0, ',', '.') }} VNĐ</td>
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
                                                <span class="status-chip status-green">Đã thanh toán</span>
                                            @elseif($payment->payment_status === 'refunded')
                                                <span class="status-chip status-red">Hoàn tiền</span>
                                            @else
                                                <span class="status-chip status-dark">{{ $payment->payment_status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment->note ?: '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="rounded-2xl border border-dashed border-slate-300 px-5 py-8 text-center text-sm text-slate-500">
                            Booking này chưa có giao dịch thanh toán nào.
                        </div>
                    @endif

                    <div class="signature-grid">
                        <div class="signature-box">
                            <div class="signature-title">Khách hàng</div>
                            <div class="signature-line"></div>
                            <div class="signature-note">(Ký và ghi rõ họ tên)</div>
                        </div>

                        <div class="signature-box">
                            <div class="signature-title">Nhân viên / Thu ngân</div>
                            <div class="signature-line"></div>
                            <div class="signature-note">(Ký và ghi rõ họ tên)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>