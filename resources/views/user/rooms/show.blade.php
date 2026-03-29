@php
    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $galleryImages = [
        $assetOrFallback('images/user/room-detail-1.jpg', 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=80'),
        $assetOrFallback('images/user/room-detail-2.jpg', 'https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8?auto=format&fit=crop&w=1400&q=80'),
        $assetOrFallback('images/user/room-detail-3.jpg', 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=1400&q=80'),
        $assetOrFallback('images/user/room-detail-4.jpg', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1400&q=80'),
        $assetOrFallback('images/user/room-detail-5.jpg', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1400&q=80'),
    ];

    $badgeClasses = match($room->status) {
        'available' => 'bg-emerald-100 text-emerald-700',
        'booked' => 'bg-amber-100 text-amber-700',
        'occupied' => 'bg-rose-100 text-rose-700',
        default => 'bg-slate-100 text-slate-700',
    };

    $statusText = match($room->status) {
        'available' => 'Còn trống',
        'booked' => 'Đã được đặt',
        'occupied' => 'Đang sử dụng',
        default => ucfirst($room->status),
    };

    $checkInDate = request('check_in_date');
    $checkOutDate = request('check_out_date');
    $today = now()->toDateString();

    $capacity = (int) ($room->roomType?->capacity ?? 2);
    $price = (int) ($room->roomType?->price ?? 0);

    $area = match(true) {
        $capacity >= 4 => '42 - 55 m²',
        $capacity === 3 => '32 - 40 m²',
        $capacity === 2 => '26 - 34 m²',
        default => '22 - 28 m²',
    };

    $bedInfo = match(true) {
        str_contains(strtolower($room->roomType?->name ?? ''), 'family') => '2 giường lớn',
        str_contains(strtolower($room->roomType?->name ?? ''), 'suite') => '1 giường king + sofa',
        str_contains(strtolower($room->roomType?->name ?? ''), 'double') => '1 giường đôi lớn',
        str_contains(strtolower($room->roomType?->name ?? ''), 'single') => '1 giường đơn',
        default => '1 giường đôi',
    };

    $viewInfo = match(true) {
        str_contains(strtolower($room->roomType?->name ?? ''), 'city') => 'Hướng thành phố',
        str_contains(strtolower($room->roomType?->name ?? ''), 'suite') => 'View cao tầng thoáng rộng',
        $price >= 1500000 => 'View đẹp, nhiều ánh sáng tự nhiên',
        default => 'View nội khu yên tĩnh',
    };

    $amenities = [
        ['icon' => '🛏️', 'title' => 'Giường tiêu chuẩn cao cấp', 'desc' => $bedInfo],
        ['icon' => '📶', 'title' => 'WiFi tốc độ cao', 'desc' => 'Phù hợp làm việc và giải trí'],
        ['icon' => '❄️', 'title' => 'Điều hòa riêng', 'desc' => 'Điều chỉnh nhiệt độ linh hoạt'],
        ['icon' => '🛁', 'title' => 'Phòng tắm riêng', 'desc' => 'Khu vệ sinh sạch sẽ, riêng tư'],
        ['icon' => '☕', 'title' => 'Nước uống / trà / cafe', 'desc' => 'Chuẩn bị sẵn trong phòng'],
        ['icon' => '🧴', 'title' => 'Đồ dùng cá nhân', 'desc' => 'Khăn, dầu gội, sữa tắm cơ bản'],
        ['icon' => '📺', 'title' => 'TV màn hình phẳng', 'desc' => 'Giải trí trong thời gian lưu trú'],
        ['icon' => '🪟', 'title' => 'Không gian thoáng', 'desc' => $viewInfo],
    ];

    $highlights = [
        'Thiết kế hiện đại, phù hợp cho khách nghỉ ngắn ngày hoặc công tác.',
        'Không gian yên tĩnh, dễ nghỉ ngơi và thuận tiện cho sinh hoạt cá nhân.',
        'Thông tin giá, sức chứa và tình trạng booking được hiển thị rõ ràng.',
        'Có thể tra cứu booking và tình trạng thanh toán dễ dàng sau khi đặt phòng.',
    ];

    $policies = [
        ['title' => 'Giờ nhận phòng', 'value' => 'Từ 14:00'],
        ['title' => 'Giờ trả phòng', 'value' => 'Trước 12:00'],
        ['title' => 'Chính sách trẻ em', 'value' => 'Có thể áp dụng phụ thu tùy hạng phòng và số lượng khách.'],
        ['title' => 'Chính sách xác nhận', 'value' => 'Booking từ website sẽ ở trạng thái pending cho tới khi admin xác nhận.'],
        ['title' => 'Thanh toán', 'value' => 'Có thể thanh toán một phần hoặc toàn bộ tùy quy trình xử lý phía khách sạn.'],
        ['title' => 'Lưu ý', 'value' => 'Vui lòng chuẩn bị giấy tờ cá nhân khi check-in.'],
    ];

    $faqs = [
        ['q' => 'Phòng này phù hợp cho bao nhiêu người?', 'a' => 'Phòng hiện phù hợp tối đa khoảng ' . $capacity . ' người theo sức chứa cấu hình của hệ thống.'],
        ['q' => 'Tôi có thể đặt phòng trực tiếp từ trang này không?', 'a' => 'Có. Bạn có thể bấm "Đặt phòng ngay" để đi đến form đặt phòng, nhập ngày ở và thông tin liên hệ.'],
        ['q' => 'Nếu tôi đã gửi booking thì xem lại ở đâu?', 'a' => 'Bạn có thể dùng mã booking cùng email hoặc số điện thoại để tra cứu lại trạng thái booking.'],
        ['q' => 'Tình trạng phòng trên trang này có chính xác theo ngày không?', 'a' => 'Khi bạn tìm phòng theo ngày ở danh sách phòng, hệ thống sẽ lọc theo logic overlap booking để đảm bảo chính xác hơn so với chỉ nhìn room status hiện tại.'],
    ];
@endphp

<x-layouts.public
    title="Phòng {{ $room->room_number }} - {{ $room->roomType?->name }} | Hotel Booking"
    metaDescription="Khám phá chi tiết phòng {{ $room->room_number }} - {{ $room->roomType?->name }}, xem giá, sức chứa, tiện ích, chính sách lưu trú và gửi yêu cầu đặt phòng nhanh chóng."
>
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('home') }}" class="transition hover:text-sky-600">Trang chủ</a>
                <span>/</span>
                <a href="{{ route('public.rooms.index') }}" class="transition hover:text-sky-600">Phòng</a>
                <span>/</span>
                <span class="text-slate-900">Phòng {{ $room->room_number }}</span>
            </div>

            <div class="mt-5 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                            {{ $room->roomType?->name }}
                        </span>

                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                            {{ $statusText }}
                        </span>
                    </div>

                    <h1 class="mt-4 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">
                        Phòng {{ $room->room_number }}
                    </h1>

                    <p class="mt-4 max-w-3xl text-base leading-8 text-slate-600">
                        {{ $room->roomType?->description ?: 'Không gian lưu trú tiện nghi, phù hợp cho khách nghỉ dưỡng, công tác hoặc lưu trú ngắn ngày với trải nghiệm rõ ràng, trực quan và dễ đặt phòng.' }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a
                        href="{{ route('public.rooms.index', array_filter([
                            'check_in_date' => $checkInDate,
                            'check_out_date' => $checkOutDate,
                        ])) }}"
                        class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        ← Quay lại danh sách phòng
                    </a>

                    <a
                        href="{{ route('public.bookings.create', array_filter([
                            'room' => $room->id,
                            'check_in_date' => $checkInDate,
                            'check_out_date' => $checkOutDate,
                        ])) }}"
                        class="rounded-2xl bg-sky-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600"
                    >
                        Đặt phòng ngay
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
            <div class="space-y-8">
                <div class="grid gap-4 lg:grid-cols-[1.25fr_0.75fr]">
                    <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                        <img
                            src="{{ $galleryImages[0] }}"
                            alt="Ảnh chính phòng {{ $room->room_number }}"
                            class="h-[420px] w-full object-cover"
                        >
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                        @foreach(array_slice($galleryImages, 1, 4) as $image)
                            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                                <img
                                    src="{{ $image }}"
                                    alt="Hình ảnh thêm của phòng {{ $room->room_number }}"
                                    class="h-[198px] w-full object-cover"
                                    loading="lazy"
                                >
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-4">
                    <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Giá / đêm</p>
                        <p class="mt-3 text-2xl font-black text-slate-900">
                            {{ number_format($price, 0, ',', '.') }} đ
                        </p>
                    </div>

                    <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Sức chứa</p>
                        <p class="mt-3 text-2xl font-black text-slate-900">
                            {{ $capacity }} người
                        </p>
                    </div>

                    <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Diện tích ước tính</p>
                        <p class="mt-3 text-2xl font-black text-slate-900">
                            {{ $area }}
                        </p>
                    </div>

                    <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs uppercase tracking-wide text-slate-500">Tầng / view</p>
                        <p class="mt-3 text-lg font-black text-slate-900">
                            {{ $room->floor ?? 'N/A' }} · {{ $viewInfo }}
                        </p>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Tổng quan phòng</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Không gian lưu trú được thiết kế để thoải mái và dễ sử dụng
                    </h2>

                    <div class="mt-6 space-y-5 text-base leading-8 text-slate-600">
                        <p>
                            {{ $room->roomType?->description ?: 'Hạng phòng này được thiết kế theo hướng hiện đại, tối ưu cho trải nghiệm lưu trú ngắn ngày và dài ngày với quy trình đặt phòng rõ ràng, minh bạch.' }}
                        </p>
                        <p>
                            Phòng {{ $room->room_number }} phù hợp cho khách cần một không gian sạch sẽ, thuận tiện và dễ tiếp cận thông tin trước khi đặt. Website hiển thị rõ mức giá, sức chứa, tình trạng phòng và liên kết trực tiếp đến form đặt phòng hoặc tra cứu booking sau khi đặt.
                        </p>
                        <p>
                            Với cách trình bày này, trang chi tiết phòng không chỉ giúp tăng khả năng chuyển đổi mà còn tạo ra nhiều nội dung hơn để hỗ trợ SEO, giống tinh thần của các website đặt phòng lớn.
                        </p>
                    </div>

                    <div class="mt-8 grid gap-4 md:grid-cols-2">
                        @foreach($highlights as $item)
                            <div class="flex gap-3 rounded-3xl bg-slate-50 p-4">
                                <div class="mt-1 text-sky-600">✓</div>
                                <p class="text-sm leading-7 text-slate-700">{{ $item }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Tiện ích trong phòng</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Những tiện nghi giúp trải nghiệm lưu trú đầy đủ hơn
                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        @foreach($amenities as $amenity)
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                <div class="text-3xl">{{ $amenity['icon'] }}</div>
                                <h3 class="mt-4 text-lg font-extrabold text-slate-900">{{ $amenity['title'] }}</h3>
                                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $amenity['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Chính sách lưu trú</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Thông tin cần biết trước khi đặt phòng
                    </h2>

                    <div class="mt-8 grid gap-4 md:grid-cols-2">
                        @foreach($policies as $policy)
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-slate-500">{{ $policy['title'] }}</p>
                                <p class="mt-3 text-sm leading-7 text-slate-700">{{ $policy['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Câu hỏi thường gặp</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Giải đáp nhanh về hạng phòng này
                    </h2>

                    <div class="mt-8 space-y-4">
                        @foreach($faqs as $faq)
                            <details class="group rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                <summary class="cursor-pointer list-none text-lg font-extrabold text-slate-900">
                                    {{ $faq['q'] }}
                                </summary>
                                <p class="mt-4 text-sm leading-7 text-slate-600">
                                    {{ $faq['a'] }}
                                </p>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-sky-600">{{ $room->roomType?->name }}</p>
                            <h2 class="mt-2 text-2xl font-black text-slate-900">Đặt phòng {{ $room->room_number }}</h2>
                        </div>

                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                            {{ $statusText }}
                        </span>
                    </div>

                    <div class="mt-6 rounded-3xl bg-slate-50 p-5">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Giá tham khảo / đêm</span>
                            <strong class="text-lg text-slate-900">{{ number_format($price, 0, ',', '.') }} đ</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Sức chứa tối đa</span>
                            <strong class="text-slate-900">{{ $capacity }} người</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Diện tích</span>
                            <strong class="text-slate-900">{{ $area }}</strong>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-slate-600">
                            <span>Loại giường</span>
                            <strong class="text-slate-900">{{ $bedInfo }}</strong>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('public.bookings.create', ['room' => $room->id]) }}" class="mt-6 space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày nhận phòng</label>
                            <input
                                type="date"
                                name="check_in_date"
                                min="{{ $today }}"
                                value="{{ $checkInDate }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                            >
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày trả phòng</label>
                            <input
                                type="date"
                                name="check_out_date"
                                min="{{ $checkInDate ?: $today }}"
                                value="{{ $checkOutDate }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                            >
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-2xl bg-sky-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600"
                        >
                            Kiểm tra và đặt phòng
                        </button>
                    </form>

                    <div class="mt-5 rounded-3xl border border-sky-200 bg-sky-50 p-4 text-sm leading-7 text-sky-900">
                        Booking gửi từ website sẽ được tạo ở trạng thái <strong>pending</strong>. Sau đó admin có thể xác nhận và cập nhật thanh toán trong hệ thống quản trị.
                    </div>

                    <div class="mt-5 flex flex-col gap-3">
                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="rounded-2xl border border-slate-300 px-4 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                        >
                            Tra cứu booking
                        </a>

                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="rounded-2xl border border-slate-300 px-4 py-3 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                        >
                            Xem thêm phòng khác
                        </a>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900">Phù hợp với ai?</h3>
                    <div class="mt-5 space-y-3 text-sm leading-7 text-slate-600">
                        <p>• Khách đi công tác cần phòng gọn gàng, tiện nghi.</p>
                        <p>• Cặp đôi hoặc nhóm nhỏ muốn không gian riêng tư.</p>
                        <p>• Gia đình nhỏ cần lựa chọn lưu trú rõ giá và dễ tra cứu.</p>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-slate-950 p-6 text-white shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-300">Hỗ trợ nhanh</p>
                    <h3 class="mt-3 text-2xl font-black">Cần tư vấn thêm?</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-300">
                        Nếu bạn đang phân vân giữa các hạng phòng, hãy bắt đầu từ danh sách phòng và lọc theo ngày, sức chứa hoặc khoảng giá.
                    </p>
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="mt-6 inline-flex rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-100"
                    >
                        Khám phá danh sách phòng
                    </a>
                </div>
            </aside>
        </div>
    </section>

    <section class="bg-slate-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">
                        Phòng liên quan
                    </p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-900">
                        Một số phòng cùng hạng bạn có thể quan tâm
                    </h2>
                </div>

                <a
                    href="{{ route('public.rooms.index', ['room_type_id' => $room->room_type_id]) }}"
                    class="inline-flex rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                >
                    Xem các phòng cùng loại
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($relatedRooms as $relatedRoom)
                    @php
                        $relatedImage = $galleryImages[$loop->index % count($galleryImages)];

                        $relatedBadgeClasses = match($relatedRoom->status) {
                            'available' => 'bg-emerald-100 text-emerald-700',
                            'booked' => 'bg-amber-100 text-amber-700',
                            'occupied' => 'bg-rose-100 text-rose-700',
                            default => 'bg-slate-100 text-slate-700',
                        };

                        $relatedStatusText = match($relatedRoom->status) {
                            'available' => 'Còn trống',
                            'booked' => 'Đã được đặt',
                            'occupied' => 'Đang sử dụng',
                            default => ucfirst($relatedRoom->status),
                        };
                    @endphp

                    <article class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative h-56 overflow-hidden">
                            <img
                                src="{{ $relatedImage }}"
                                alt="Hình ảnh phòng {{ $relatedRoom->room_number }}"
                                class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                loading="lazy"
                            >
                            <div class="absolute right-4 top-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $relatedBadgeClasses }}">
                                    {{ $relatedStatusText }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <p class="text-sm font-semibold text-sky-600">
                                {{ $relatedRoom->roomType?->name }}
                            </p>

                            <h3 class="mt-2 text-2xl font-black text-slate-900">
                                Phòng {{ $relatedRoom->room_number }}
                            </h3>

                            <div class="mt-5 grid grid-cols-2 gap-4 rounded-3xl bg-slate-50 p-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-slate-500">Giá / đêm</p>
                                    <p class="mt-2 text-lg font-black text-slate-900">
                                        {{ number_format($relatedRoom->roomType?->price ?? 0, 0, ',', '.') }} đ
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs uppercase tracking-wide text-slate-500">Sức chứa</p>
                                    <p class="mt-2 text-lg font-black text-slate-900">
                                        {{ $relatedRoom->roomType?->capacity ?? 0 }} người
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 flex gap-3">
                                <a
                                    href="{{ route('public.rooms.show', $relatedRoom) }}"
                                    class="rounded-2xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                                >
                                    Xem chi tiết
                                </a>

                                <a
                                    href="{{ route('public.bookings.create', ['room' => $relatedRoom->id]) }}"
                                    class="rounded-2xl bg-sky-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-600"
                                >
                                    Đặt ngay
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                        Hiện chưa có thêm phòng cùng loại để hiển thị.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.public>