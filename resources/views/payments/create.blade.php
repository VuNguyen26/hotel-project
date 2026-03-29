<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Ghi nhận thanh toán
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Chọn booking và ghi nhận số tiền khách đã thanh toán.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="section-title">Thông tin thanh toán</h3>
                </div>

                <div class="form-card-body">
                    @if ($errors->any())
                        <div class="alert-error mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($payableBookings->count() == 0)
                        <div class="empty-state">
                            Hiện không có booking nào cần thanh toán thêm.
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('payments.index') }}" class="btn-secondary">
                                Quay lại danh sách thanh toán
                            </a>
                        </div>
                    @else
                        <form action="{{ route('payments.store') }}" method="POST" class="space-y-5">
                            @csrf

                            <div>
                                <label for="booking_id" class="form-label">Booking</label>
                                <select name="booking_id" id="booking_id" class="form-select">
                                    <option value="">-- Chọn booking cần thanh toán --</option>
                                    @foreach($payableBookings as $booking)
                                        @php
                                            $paidAmount = $booking->payments->where('payment_status', 'paid')->sum('amount');
                                            $remainingAmount = $booking->total_price - $paidAmount;
                                        @endphp
                                        <option
                                            value="{{ $booking->id }}"
                                            data-remaining="{{ $remainingAmount }}"
                                            {{ old('booking_id', $preselectedBookingId) == $booking->id ? 'selected' : '' }}
                                        >
                                            Booking #{{ $booking->id }} -
                                            {{ $booking->customer->full_name }} -
                                            Phòng {{ $booking->room->room_number }} -
                                            Còn lại {{ number_format($remainingAmount, 0, ',', '.') }} VNĐ
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                                <div class="text-sm text-slate-500">Số tiền còn lại</div>
                                <div id="remaining-display" class="mt-1 text-2xl font-bold text-blue-600">0 VNĐ</div>
                            </div>

                            <div>
                                <label for="amount" class="form-label">Số tiền thanh toán</label>
                                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" class="form-input" placeholder="Nhập số tiền khách thanh toán">
                            </div>

                            <div>
                                <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                                <select name="payment_method" id="payment_method" class="form-select">
                                    <option value="">-- Chọn phương thức --</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                                    <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Chuyển khoản</option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Thẻ</option>
                                </select>
                            </div>

                            <div>
                                <label for="note" class="form-label">Ghi chú</label>
                                <textarea name="note" id="note" rows="4" class="form-textarea" placeholder="Nhập ghi chú nếu có">{{ old('note') }}</textarea>
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="submit" class="btn-primary">Lưu thanh toán</button>
                                <a href="{{ route('payments.index') }}" class="btn-secondary">Quay lại</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const bookingSelect = document.getElementById('booking_id');
        const amountInput = document.getElementById('amount');
        const remainingDisplay = document.getElementById('remaining-display');

        function formatVND(number) {
            return new Intl.NumberFormat('vi-VN').format(number) + ' VNĐ';
        }

        function updateRemainingAmount() {
            if (!bookingSelect) return;

            const selectedOption = bookingSelect.options[bookingSelect.selectedIndex];
            const remaining = selectedOption ? Number(selectedOption.dataset.remaining || 0) : 0;

            remainingDisplay.textContent = formatVND(remaining);

            if (!amountInput.value && remaining > 0) {
                amountInput.value = remaining;
            }
        }

        if (bookingSelect) {
            bookingSelect.addEventListener('change', function () {
                amountInput.value = '';
                updateRemainingAmount();
            });

            updateRemainingAmount();
        }
    </script>
</x-app-layout>