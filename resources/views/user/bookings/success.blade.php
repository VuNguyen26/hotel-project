@php
    use Carbon\Carbon;

    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $coverImage = $assetOrFallback(
        'images/user/booking-success-cover.jpg',
        'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1600&q=80'
    );

    $statusText = match($summary['status']) {
        'pending' => 'Chờ xác nhận',
        'confirmed' => 'Đã xác nhận',
        'checked_in' => 'Đã check-in',
        'checked_out' => 'Đã check-out',
        'cancelled' => 'Đã hủy',
        default => ucfirst((string) $summary['status']),
    };

    $statusBadge = match($summary['status']) {
        'pending' => 'bg-amber-100 text-amber-700',
        'confirmed' => 'bg-sky-100 text-sky-700',
        'checked_in' => 'bg-emerald-100 text-emerald-700',
        'checked_out' => 'bg-slate-100 text-slate-700',
        'cancelled' => 'bg-rose-100 text-rose-700',
        default => 'bg-slate-100 text-slate-700',
    };

    $checkIn = Carbon::parse($summary['check_in_date']);
    $checkOut = Carbon::parse($summary['check_out_date']);

    $heroStats = [
        ['label' => 'Mã booking', 'value' => $summary['booking_code']],
        ['label' => 'Tổng tiền dự kiến', 'value' => number_format((float) $summary['total_price'], 0, ',', '.') . ' đ'],
        ['label' => 'Số đêm lưu trú', 'value' => $summary['nights'] . ' đêm'],
    ];

    $customerCards = [
        [
            'label' => 'Họ và tên',
            'value' => $summary['customer_name'] ?: 'Chưa cập nhật',
        ],
        [
            'label' => 'Số điện thoại',
            'value' => $summary['customer_phone'] ?: 'Chưa cung cấp',
        ],
        [
            'label' => 'Email',
            'value' => $summary['customer_email'] ?: 'Chưa cung cấp',
        ],
    ];

    $stayCards = [
        [
            'label' => 'Phòng',
            'value' => ($summary['room_number'] ?: 'N/A') . ' · ' . ($summary['room_type'] ?: 'Đang cập nhật'),
        ],
        [
            'label' => 'Nhận phòng',
            'value' => $checkIn->format('d/m/Y'),
        ],
        [
            'label' => 'Trả phòng',
            'value' => $checkOut->format('d/m/Y'),
        ],
        [
            'label' => 'Số khách',
            'value' => $summary['adults'] . ' người lớn' . ((int) $summary['children'] > 0 ? ', ' . $summary['children'] . ' trẻ em' : ''),
        ],
    ];

    $nextSteps = [
        'Lưu lại mã booking để tra cứu hoặc đối chiếu khi cần.',
        'Theo dõi trạng thái xác nhận của booking tại trang tra cứu.',
        'Nếu cần thay đổi lịch lưu trú, nên liên hệ sớm để được hỗ trợ nhanh hơn.',
    ];

    $statusNote = match($summary['status']) {
        'pending' => 'Yêu cầu đặt phòng đã được ghi nhận thành công và đang chờ bộ phận vận hành xác nhận.',
        'confirmed' => 'Booking đã được xác nhận thành công trên hệ thống.',
        'checked_in' => 'Booking đã chuyển sang trạng thái khách nhận phòng.',
        'checked_out' => 'Booking đã hoàn tất lưu trú.',
        'cancelled' => 'Booking hiện không còn hiệu lực.',
        default => 'Booking đã được ghi nhận trên hệ thống.',
    };
@endphp

<x-layouts.public
    title="Đặt phòng thành công | Navara Boutique Hotel"
    metaDescription="Booking của bạn đã được ghi nhận thành công tại Navara Boutique Hotel. Xem mã booking, thông tin lưu trú và các bước tiếp theo để tiện theo dõi."
>
    <style>
        :root {
            --navara-navy: #173F8A;
            --navara-navy-deep: #081A45;
            --navara-teal: #2EC4B6;
            --navara-teal-dark: #27B0A3;
            --navara-border: rgba(15, 23, 42, 0.08);
            --navara-shadow-soft: 0 14px 40px rgba(15, 23, 42, 0.06);
            --navara-shadow-lg: 0 28px 70px rgba(8, 26, 69, 0.14);
        }

        @keyframes floatSoft {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .success-shell-card {
            border: 1px solid var(--navara-border);
            box-shadow: var(--navara-shadow-soft);
        }

        .success-floating-orb {
            animation: floatSoft 7s ease-in-out infinite;
        }

        .success-chip {
            border: 1px solid rgba(23, 63, 138, 0.08);
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(6px);
        }

        .success-side-sticky {
            position: sticky;
            top: 6.75rem;
        }
    </style>

    <section class="relative overflow-hidden bg-[#081A45] text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(46,196,182,0.22),transparent_24%),radial-gradient(circle_at_left,rgba(255,255,255,0.08),transparent_18%)]"></div>
        <div class="success-floating-orb absolute -left-16 top-16 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        <div class="success-floating-orb absolute right-0 top-24 h-56 w-56 rounded-full bg-[#2EC4B6]/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="grid items-center gap-10 lg:grid-cols-[1.08fr_0.92fr]">
                <div>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-white/80">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Trang chủ</a>
                        <span class="text-white/35">/</span>
                        <a href="{{ route('public.rooms.index') }}" class="transition hover:text-white">Phòng nghỉ</a>
                        <span class="text-white/35">/</span>
                        <span class="text-white">Đặt phòng thành công</span>
                    </div>

                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#9ff4ec]">
                            Booking đã được ghi nhận
                        </span>
                        <span class="rounded-full px-4 py-2 text-xs font-bold {{ $statusBadge }}">
                            {{ $statusText }}
                        </span>
                    </div>

                    <h1 class="mt-6 max-w-3xl text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-[3.4rem] lg:leading-[1.08]">
                        Yêu cầu đặt phòng của anh đã được gửi thành công vào hệ thống.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-slate-200 sm:text-lg">
                        Mã booking đã được tạo ngay sau khi gửi biểu mẫu. Anh chỉ cần lưu lại mã này để tiện tra cứu lại trạng thái booking hoặc đối chiếu khi cần.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="#booking-success-detail"
                            class="nav-btn-hover inline-flex rounded-full bg-[#2EC4B6] px-6 py-3 text-sm font-semibold text-[#081A45] hover:bg-[#27B0A3]"
                        >
                            Xem chi tiết booking
                        </a>

                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex rounded-full border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15"
                        >
                            Tra cứu booking
                        </a>
                    </div>
                </div>

                <div class="success-shell-card overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 p-5 backdrop-blur-sm sm:p-6">
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/95 p-6 text-slate-900 shadow-[0_24px_60px_rgba(8,26,69,0.24)] sm:p-7">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Tóm tắt nhanh</p>
                                <h2 class="mt-3 text-2xl font-black tracking-tight text-slate-900">
                                    Những thông tin quan trọng cần lưu lại
                                </h2>
                            </div>

                            <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-right">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Trạng thái hiện tại</p>
                                <p class="mt-2 text-sm font-bold text-emerald-800">{{ $statusText }}</p>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3">
                            @foreach($heroStats as $stat)
                                <div class="rounded-[1.4rem] border border-slate-200 bg-white p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $stat['label'] }}</p>
                                    <p class="mt-2 text-lg font-black text-slate-900">{{ $stat['value'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                            {{ $statusNote }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="booking-success-detail" class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="grid gap-8 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="space-y-8">
                <div class="success-shell-card overflow-hidden rounded-[2rem] bg-white">
                    <div class="grid gap-0 lg:grid-cols-[0.92fr_1.08fr]">
                        <div class="relative min-h-[320px] overflow-hidden">
                            <img
                                src="{{ $coverImage }}"
                                alt="Đặt phòng thành công"
                                class="h-full w-full object-cover"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-[#081A45]/80 via-[#081A45]/20 to-transparent"></div>

                            <div class="absolute inset-x-6 bottom-6 text-white">
                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full bg-white/92 px-3 py-1.5 text-xs font-bold text-[#173F8A] shadow-sm">
                                        {{ $summary['room_type'] ?: 'Phòng nghỉ' }}
                                    </span>
                                    <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $statusBadge }} shadow-sm">
                                        {{ $statusText }}
                                    </span>
                                </div>

                                <p class="mt-5 text-xs font-semibold uppercase tracking-[0.18em] text-white/70">
                                    Phòng {{ $summary['room_number'] ?: 'N/A' }}
                                </p>
                                <h2 class="mt-2 text-3xl font-black">
                                    {{ $checkIn->format('d/m/Y') }} → {{ $checkOut->format('d/m/Y') }}
                                </h2>
                            </div>
                        </div>

                        <div class="p-6 sm:p-8">
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Booking vừa tạo</p>
                            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                                Thông tin lưu trú đã được ghi nhận rõ ràng và sẵn sàng để tra cứu lại.
                            </h2>

                            <div class="mt-8 grid gap-4 md:grid-cols-2">
                                <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5 md:col-span-2">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Mã booking</p>
                                    <p class="mt-3 text-2xl font-black text-slate-900">{{ $summary['booking_code'] }}</p>
                                    <p class="mt-2 text-sm leading-7 text-slate-600">
                                        Hãy lưu lại mã này để tra cứu lại trạng thái booking trong những lần sau.
                                    </p>
                                </div>

                                @foreach($customerCards as $card)
                                    <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $card['label'] }}</p>
                                        <p class="mt-3 text-lg font-black text-slate-900">{{ $card['value'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="success-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Thông tin lưu trú</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Tóm tắt phòng đã chọn và lịch ở của booking
                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        @foreach($stayCards as $card)
                            <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $card['label'] }}</p>
                                <p class="mt-3 text-lg font-black text-slate-900">{{ $card['value'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 rounded-[1.6rem] border border-sky-200 bg-sky-50 p-5 text-sm leading-7 text-sky-900">
                        Booking này đang ở trạng thái <strong>{{ $statusText }}</strong>. Trong giai đoạn tiếp theo, bộ phận vận hành sẽ tiếp nhận và cập nhật tình trạng phù hợp theo quy trình thực tế.
                    </div>
                </div>

                <div class="success-shell-card rounded-[2rem] bg-white p-6 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Các bước tiếp theo</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Làm gì sau khi gửi booking thành công?
                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-3">
                        @foreach($nextSteps as $step)
                            <div class="rounded-[1.6rem] border border-slate-200 bg-slate-50 p-5">
                                <div class="text-[#173F8A]">✓</div>
                                <p class="mt-3 text-sm leading-7 text-slate-700">{{ $step }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="space-y-6 success-side-sticky">
                <div class="success-shell-card rounded-[2rem] bg-white p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Thông tin cần nhớ</p>
                    <h2 class="mt-3 text-2xl font-black text-slate-900">Lưu lại mã booking</h2>

                    <div class="mt-6 rounded-[1.6rem] bg-slate-50 p-5 text-center">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Mã booking của anh</p>
                        <p class="mt-3 text-2xl font-black text-slate-900 break-all">{{ $summary['booking_code'] }}</p>
                    </div>

                    <div class="mt-5 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">
                        Khi cần tra cứu lại, anh chỉ cần nhập mã booking kèm số điện thoại hoặc email đã dùng lúc đặt phòng.
                    </div>
                </div>

                <div class="success-shell-card rounded-[2rem] bg-white p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#173F8A]">Hành động tiếp theo</p>
                    <div class="mt-5 grid gap-3">
                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full bg-[#173F8A] px-5 py-3 text-sm font-semibold text-white hover:bg-[#143374]"
                        >
                            Tra cứu booking
                        </a>

                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                        >
                            Xem thêm phòng khác
                        </a>

                        <a
                            href="{{ route('home') }}"
                            class="nav-btn-hover inline-flex items-center justify-center rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:border-[#173F8A]/20 hover:bg-slate-50 hover:text-[#173F8A]"
                        >
                            Về trang chủ
                        </a>
                    </div>
                </div>

                <div class="success-shell-card rounded-[2rem] bg-[#081A45] p-6 text-white">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#9ff4ec]">Tiếp tục hành trình</p>
                    <h3 class="mt-3 text-2xl font-black">Muốn xem thêm hạng phòng khác?</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Anh có thể quay lại danh sách phòng để tiếp tục tham khảo các lựa chọn khác hoặc gửi booking mới khi cần.
                    </p>
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="nav-btn-hover mt-6 inline-flex rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#081A45] hover:bg-slate-100"
                    >
                        Đi tới danh sách phòng
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.public>