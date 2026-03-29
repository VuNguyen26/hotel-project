@php
    $today = now()->toDateString();

    $assetOrFallback = function (string $localPath, string $fallback) {
        return file_exists(public_path($localPath)) ? asset($localPath) : $fallback;
    };

    $heroImage = $assetOrFallback(
        'images/user/hero-hotel.jpg',
        'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80'
    );

    $roomTypeImages = [
        $assetOrFallback('images/user/room-type-1.jpg', 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-2.jpg', 'https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-3.jpg', 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-4.jpg', 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-5.jpg', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/room-type-6.jpg', 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80'),
    ];

    $featureRoomsImages = [
        $assetOrFallback('images/user/featured-room-1.jpg', 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-2.jpg', 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-3.jpg', 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-4.jpg', 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-5.jpg', 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=1200&q=80'),
        $assetOrFallback('images/user/featured-room-6.jpg', 'https://images.unsplash.com/photo-1455587734955-081b22074882?auto=format&fit=crop&w=1200&q=80'),
    ];

    $services = [
        ['icon' => '🏊', 'title' => 'Hồ bơi thư giãn', 'desc' => 'Không gian hồ bơi thoáng đãng, phù hợp nghỉ dưỡng và thư giãn cuối tuần.'],
        ['icon' => '🍽️', 'title' => 'Buffet sáng', 'desc' => 'Thực đơn đa dạng với món Á - Âu và bữa sáng tiện lợi cho khách công tác.'],
        ['icon' => '📶', 'title' => 'WiFi tốc độ cao', 'desc' => 'Phù hợp cho nhu cầu làm việc, học tập trực tuyến và giải trí mọi lúc.'],
        ['icon' => '🚗', 'title' => 'Bãi đỗ xe', 'desc' => 'Có khu vực đậu xe thuận tiện cho khách đi cá nhân hoặc đi theo nhóm.'],
        ['icon' => '🛎️', 'title' => 'Lễ tân 24/7', 'desc' => 'Hỗ trợ check-in, check-out linh hoạt và xử lý yêu cầu của khách nhanh chóng.'],
        ['icon' => '✈️', 'title' => 'Đưa đón sân bay', 'desc' => 'Tiện lợi cho khách từ xa, tối ưu trải nghiệm di chuyển và lưu trú.'],
    ];

    $benefits = [
        ['title' => 'Đặt phòng nhanh', 'desc' => 'Tìm phòng trống theo ngày và gửi yêu cầu đặt phòng chỉ trong vài bước.'],
        ['title' => 'Thông tin minh bạch', 'desc' => 'Hiển thị rõ giá phòng, sức chứa, trạng thái booking và tình trạng thanh toán.'],
        ['title' => 'Phù hợp nhiều nhu cầu', 'desc' => 'Có phòng cho khách đi công tác, cặp đôi, gia đình và nhóm nhỏ.'],
        ['title' => 'Tra cứu booking dễ dàng', 'desc' => 'Khách hàng có thể dùng mã booking và thông tin liên hệ để xem lại trạng thái.'],
    ];

    $offers = [
        ['tag' => 'Ưu đãi cuối tuần', 'title' => 'Combo nghỉ dưỡng 2N1Đ cho cặp đôi', 'desc' => 'Phù hợp cho kỳ nghỉ ngắn với không gian riêng tư, tiện nghi và vị trí thuận tiện.', 'cta' => 'Xem phòng phù hợp'],
        ['tag' => 'Gia đình', 'title' => 'Ưu đãi cho nhóm 3–4 khách', 'desc' => 'Lựa chọn các hạng phòng rộng rãi, phù hợp gia đình có trẻ nhỏ hoặc nhóm bạn.', 'cta' => 'Khám phá Family Room'],
        ['tag' => 'Công tác', 'title' => 'Lưu trú thuận tiện cho chuyến đi ngắn ngày', 'desc' => 'Phòng yên tĩnh, wifi ổn định, check-in nhanh và dễ di chuyển vào trung tâm.', 'cta' => 'Xem phòng công tác'],
    ];

    $nearbyPlaces = [
        ['name' => 'Khu ẩm thực trung tâm', 'distance' => '5 phút di chuyển', 'desc' => 'Thuận tiện khám phá ăn uống và giải trí buổi tối.'],
        ['name' => 'Trung tâm thương mại', 'distance' => '8 phút di chuyển', 'desc' => 'Dễ dàng mua sắm, cafe, gặp gỡ đối tác hoặc đi cùng gia đình.'],
        ['name' => 'Điểm tham quan nổi bật', 'distance' => '10 phút di chuyển', 'desc' => 'Phù hợp cho khách du lịch muốn kết hợp nghỉ dưỡng và khám phá thành phố.'],
    ];

    $testimonials = [
        ['name' => 'Nguyễn Minh Anh', 'type' => 'Chuyến đi gia đình', 'content' => 'Phòng sạch sẽ, dễ đặt, tra cứu booking tiện. Không gian phù hợp cho gia đình có trẻ nhỏ.'],
        ['name' => 'Trần Quốc Huy', 'type' => 'Chuyến đi công tác', 'content' => 'Mình thích vì quy trình đặt phòng nhanh, giao diện dễ dùng và kiểm tra thông tin booking rất rõ ràng.'],
        ['name' => 'Lê Hoàng Lan', 'type' => 'Nghỉ cuối tuần', 'content' => 'Vị trí thuận tiện, phòng đẹp và có nhiều lựa chọn phù hợp ngân sách khác nhau.'],
    ];

    $faqs = [
        ['q' => 'Giờ nhận phòng và trả phòng là khi nào?', 'a' => 'Thông thường giờ nhận phòng là 14:00 và giờ trả phòng là 12:00.'],
        ['q' => 'Sau khi đặt phòng thì booking có trạng thái gì?', 'a' => 'Booking từ website user sẽ được tạo ở trạng thái pending để admin xác nhận lại.'],
        ['q' => 'Tôi có thể kiểm tra booking bằng cách nào?', 'a' => 'Bạn dùng mã booking cùng email hoặc số điện thoại đã đặt để tra cứu lại booking.'],
        ['q' => 'Website có hiển thị tình trạng thanh toán không?', 'a' => 'Có. Trang tra cứu booking hiển thị tổng tiền, đã thanh toán, còn lại và lịch sử thanh toán.'],
    ];

    $newsItems = [
        [
            'image' => $assetOrFallback('images/user/news-1.jpg', 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1200&q=80'),
            'title' => 'Kinh nghiệm chọn hạng phòng phù hợp cho chuyến đi ngắn ngày',
            'desc' => 'Gợi ý cách chọn Standard, Deluxe hay Family Room theo nhu cầu nghỉ dưỡng, công tác và ngân sách.',
        ],
        [
            'image' => $assetOrFallback('images/user/news-2.jpg', 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80'),
            'title' => 'Nên đặt phòng khách sạn trước bao lâu để có lựa chọn tốt?',
            'desc' => 'Tìm hiểu thời điểm đặt phòng phù hợp để dễ chọn được hạng phòng tốt và chủ động kế hoạch di chuyển.',
        ],
        [
            'image' => $assetOrFallback('images/user/news-3.jpg', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80'),
            'title' => 'Checklist lưu trú cho gia đình có trẻ nhỏ',
            'desc' => 'Một vài lưu ý khi chọn phòng, chuẩn bị hành lý và sắp xếp tiện ích phù hợp cho chuyến đi gia đình.',
        ],
    ];
@endphp

<x-layouts.public
    title="Hotel Booking - Đặt phòng khách sạn tiện nghi, hiện đại"
    metaDescription="Khám phá phòng nghỉ, tiện ích, ưu đãi và gửi yêu cầu đặt phòng nhanh chóng tại Hotel Booking. Website hỗ trợ xem phòng, tra cứu booking và trải nghiệm lưu trú hiện đại."
>
    <section class="relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0">
            <img
                src="{{ $heroImage }}"
                alt="Không gian khách sạn hiện đại"
                class="h-full w-full object-cover opacity-35"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-sky-950/80"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
                <div>
                    <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-4 py-1.5 text-sm font-medium text-white/90">
                        Khách sạn tiện nghi · Đặt phòng nhanh chóng · Trải nghiệm cao cấp
                    </span>

                    <h1 class="mt-6 max-w-4xl text-4xl font-black leading-tight text-white sm:text-5xl lg:text-6xl">
                        Đặt phòng khách sạn
                        <span class="text-sky-300">hiện đại, trực quan</span>
                        và phù hợp cho mọi chuyến đi
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                        Từ chuyến đi công tác ngắn ngày đến kỳ nghỉ gia đình cuối tuần, bạn có thể khám phá hạng phòng, kiểm tra phòng trống theo ngày và gửi yêu cầu đặt phòng chỉ trong vài bước.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="rounded-2xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-900/30 transition hover:bg-sky-600"
                        >
                            Xem phòng ngay
                        </a>

                        <a
                            href="{{ route('public.bookings.lookup') }}"
                            class="rounded-2xl border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/20"
                        >
                            Tra cứu booking
                        </a>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-sm text-slate-300">Loại phòng</p>
                            <p class="mt-2 text-3xl font-extrabold text-white">{{ $stats['room_types'] }}</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-sm text-slate-300">Phòng trống hiện tại</p>
                            <p class="mt-2 text-3xl font-extrabold text-white">{{ $stats['available_rooms'] }}</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-sm text-slate-300">Booking đã ghi nhận</p>
                            <p class="mt-2 text-3xl font-extrabold text-white">{{ $stats['bookings'] }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="rounded-[2rem] border border-white/10 bg-white/95 p-6 shadow-2xl shadow-slate-950/30">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Tìm phòng nhanh</p>
                                <h2 class="mt-2 text-2xl font-extrabold text-slate-900">Kiểm tra phòng trống theo ngày</h2>
                            </div>
                            <div class="rounded-2xl bg-sky-50 px-3 py-2 text-sm font-semibold text-sky-700">
                                Đặt nhanh
                            </div>
                        </div>

                        <form method="GET" action="{{ route('public.rooms.index') }}" class="mt-6 space-y-5">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày nhận phòng</label>
                                    <input
                                        type="date"
                                        name="check_in_date"
                                        min="{{ $today }}"
                                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    >
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Ngày trả phòng</label>
                                    <input
                                        type="date"
                                        name="check_out_date"
                                        min="{{ $today }}"
                                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    >
                                </div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Sức chứa tối thiểu</label>
                                    <select
                                        name="capacity"
                                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    >
                                        <option value="">Không giới hạn</option>
                                        <option value="1">Từ 1 người</option>
                                        <option value="2">Từ 2 người</option>
                                        <option value="3">Từ 3 người</option>
                                        <option value="4">Từ 4 người</option>
                                        <option value="5">Từ 5 người</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-slate-700">Loại phòng</label>
                                    <select
                                        name="room_type_id"
                                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                                    >
                                        <option value="">Tất cả loại phòng</option>
                                        @foreach($roomTypes as $roomType)
                                            <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="w-full rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                            >
                                Tìm phòng phù hợp
                            </button>
                        </form>

                        <div class="mt-5 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-500">Nhiều lựa chọn</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">Phòng cho công tác, cặp đôi, gia đình</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-500">Dễ tra cứu</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">Kiểm tra lại booking chỉ với mã và liên hệ</p>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs uppercase tracking-wide text-slate-500">Thông tin rõ ràng</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">Giá, tình trạng phòng và thanh toán minh bạch</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-4">
            @foreach($benefits as $item)
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-extrabold text-slate-900">{{ $item['title'] }}</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-600">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section id="room-types" class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Loại phòng nổi bật</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                    Chọn hạng phòng phù hợp với nhu cầu của bạn
                </h2>
                <p class="mt-4 text-slate-600">
                    Mỗi hạng phòng được thiết kế theo nhu cầu lưu trú khác nhau: nghỉ cá nhân, cặp đôi, gia đình hoặc khách công tác cần sự tiện nghi và yên tĩnh.
                </p>
            </div>

            <a
                href="{{ route('public.rooms.index') }}"
                class="inline-flex rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
            >
                Xem tất cả phòng
            </a>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($roomTypes as $roomType)
                @php
                    $roomTypeImage = $roomTypeImages[$loop->index % count($roomTypeImages)];
                @endphp

                <article class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative h-60 overflow-hidden">
                        <img
                            src="{{ $roomTypeImage }}"
                            alt="Hình ảnh loại phòng {{ $roomType->name }}"
                            class="h-full w-full object-cover transition duration-500 hover:scale-105"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/10 to-transparent"></div>

                        <div class="absolute left-5 top-5">
                            <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-slate-900">
                                {{ $roomType->rooms_count }} phòng
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-2xl font-extrabold text-slate-900">{{ $roomType->name }}</h3>
                                <p class="mt-3 text-sm leading-7 text-slate-600">
                                    {{ $roomType->description ?: 'Không gian lưu trú được thiết kế theo nhu cầu nghỉ dưỡng, công tác và lưu trú ngắn ngày.' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-4 rounded-3xl bg-slate-50 p-4">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-500">Giá / đêm</p>
                                <p class="mt-2 text-lg font-black text-slate-900">
                                    {{ number_format($roomType->price, 0, ',', '.') }} đ
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-500">Sức chứa</p>
                                <p class="mt-2 text-lg font-black text-slate-900">
                                    {{ $roomType->capacity }} người
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <span class="text-sm text-slate-500">Khám phá thêm các phòng cùng hạng</span>
                            <a
                                href="{{ route('public.rooms.index', ['room_type_id' => $roomType->id]) }}"
                                class="rounded-2xl bg-sky-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-600"
                            >
                                Xem phòng
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                    Chưa có loại phòng nào trong hệ thống.
                </div>
            @endforelse
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1fr_0.95fr] lg:items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Giới thiệu khách sạn</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                    Không gian lưu trú thuận tiện cho nghỉ dưỡng, công tác và gia đình
                </h2>
                <p class="mt-5 text-base leading-8 text-slate-600">
                    Hotel Booking hướng đến trải nghiệm đặt phòng trực quan, rõ ràng và dễ theo dõi. Người dùng có thể khám phá từng hạng phòng, kiểm tra phòng trống theo ngày, gửi yêu cầu đặt phòng và tra cứu lại thông tin booking ngay trên website.
                </p>
                <p class="mt-4 text-base leading-8 text-slate-600">
                    Với hệ thống phòng đa dạng, mức giá linh hoạt và quy trình đặt phòng ngắn gọn, website phù hợp cho khách đi công tác ngắn ngày, cặp đôi nghỉ cuối tuần và gia đình muốn tìm nơi lưu trú tiện nghi.
                </p>

                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    @foreach($nearbyPlaces as $place)
                        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                            <h3 class="text-lg font-extrabold text-slate-900">{{ $place['name'] }}</h3>
                            <p class="mt-2 text-sm font-semibold text-sky-600">{{ $place['distance'] }}</p>
                            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $place['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @foreach($services as $service)
                    <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="text-3xl">{{ $service['icon'] }}</div>
                        <h3 class="mt-4 text-xl font-extrabold text-slate-900">{{ $service['title'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">{{ $service['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-slate-950 py-16 text-white" id="offers">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-300">Ưu đãi & gợi ý lưu trú</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight">
                    Những lựa chọn hấp dẫn cho nhiều mục đích chuyến đi
                </h2>
                <p class="mt-4 text-slate-300">
                    Từ nghỉ cuối tuần đến lưu trú công tác, bạn có thể bắt đầu từ các gợi ý dưới đây để chọn đúng hạng phòng và mức giá phù hợp.
                </p>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach($offers as $offer)
                    <article class="rounded-[2rem] border border-white/10 bg-white/5 p-6 backdrop-blur">
                        <span class="inline-flex rounded-full bg-sky-400/15 px-3 py-1 text-xs font-semibold text-sky-300">
                            {{ $offer['tag'] }}
                        </span>
                        <h3 class="mt-4 text-2xl font-extrabold">{{ $offer['title'] }}</h3>
                        <p class="mt-4 text-sm leading-7 text-slate-300">{{ $offer['desc'] }}</p>
                        <a
                            href="{{ route('public.rooms.index') }}"
                            class="mt-6 inline-flex rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-100"
                        >
                            {{ $offer['cta'] }}
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Gợi ý phòng nổi bật</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                    Một số phòng đang được quan tâm
                </h2>
                <p class="mt-4 text-slate-600">
                    Khám phá thêm các phòng cụ thể trong hệ thống để xem giá, sức chứa, trạng thái và đi đến form đặt phòng nhanh hơn.
                </p>
            </div>

            <a
                href="{{ route('public.rooms.index') }}"
                class="inline-flex rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
            >
                Xem danh sách đầy đủ
            </a>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($featuredRooms as $room)
                @php
                    $roomImage = $featureRoomsImages[$loop->index % count($featureRoomsImages)];

                    $statusText = match($room->status) {
                        'available' => 'Còn trống',
                        'booked' => 'Đã được đặt',
                        'occupied' => 'Đang sử dụng',
                        default => ucfirst($room->status),
                    };

                    $statusClass = match($room->status) {
                        'available' => 'bg-emerald-100 text-emerald-700',
                        'booked' => 'bg-amber-100 text-amber-700',
                        'occupied' => 'bg-rose-100 text-rose-700',
                        default => 'bg-slate-100 text-slate-700',
                    };
                @endphp

                <article class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative h-56 overflow-hidden">
                        <img
                            src="{{ $roomImage }}"
                            alt="Hình ảnh phòng {{ $room->room_number }}"
                            class="h-full w-full object-cover transition duration-500 hover:scale-105"
                            loading="lazy"
                        >
                        <div class="absolute right-4 top-4">
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <p class="text-sm font-semibold text-sky-600">{{ $room->roomType?->name }}</p>
                        <h3 class="mt-2 text-2xl font-extrabold text-slate-900">Phòng {{ $room->room_number }}</h3>

                        <div class="mt-5 grid grid-cols-2 gap-4 rounded-3xl bg-slate-50 p-4">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-500">Giá / đêm</p>
                                <p class="mt-2 text-lg font-black text-slate-900">
                                    {{ number_format($room->roomType?->price ?? 0, 0, ',', '.') }} đ
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-slate-500">Sức chứa</p>
                                <p class="mt-2 text-lg font-black text-slate-900">
                                    {{ $room->roomType?->capacity ?? 0 }} người
                                </p>
                            </div>
                        </div>

                        <p class="mt-5 text-sm leading-7 text-slate-600">
                            {{ \Illuminate\Support\Str::limit($room->roomType?->description ?: 'Không gian lưu trú tiện nghi, phù hợp nhiều nhu cầu lưu trú khác nhau.', 110) }}
                        </p>

                        <div class="mt-6 flex gap-3">
                            <a
                                href="{{ route('public.rooms.show', $room) }}"
                                class="rounded-2xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                            >
                                Xem chi tiết
                            </a>

                            <a
                                href="{{ route('public.bookings.create', ['room' => $room->id]) }}"
                                class="rounded-2xl bg-sky-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-sky-600"
                            >
                                Đặt ngay
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                    Chưa có phòng nổi bật để hiển thị.
                </div>
            @endforelse
        </div>
    </section>

    <section id="reviews" class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Đánh giá khách hàng</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                    Trải nghiệm lưu trú được phản hồi tích cực
                </h2>
                <p class="mt-4 text-slate-600">
                    Những phản hồi dưới đây giúp tăng độ tin cậy cho website và cũng là một dạng nội dung rất tốt cho trải nghiệm người dùng.
                </p>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach($testimonials as $review)
                    <article class="rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                        <div class="text-amber-500">★★★★★</div>
                        <p class="mt-4 text-base leading-8 text-slate-700">
                            “{{ $review['content'] }}”
                        </p>
                        <div class="mt-6">
                            <p class="font-extrabold text-slate-900">{{ $review['name'] }}</p>
                            <p class="text-sm text-slate-500">{{ $review['type'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="faq" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Câu hỏi thường gặp</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                    Giải đáp nhanh trước khi bạn đặt phòng
                </h2>
                <p class="mt-4 text-slate-600">
                    Phần FAQ giúp khách hàng hiểu rõ quy trình đặt phòng, trạng thái booking và cách tra cứu lại thông tin. Đây cũng là khối nội dung rất tốt cho SEO.
                </p>
            </div>

            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <details class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
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
    </section>

    <section id="news" class="bg-slate-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Tin tức & cẩm nang</p>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">
                        Nội dung hữu ích giúp website hấp dẫn hơn và hỗ trợ SEO
                    </h2>
                    <p class="mt-4 text-slate-600">
                        Đây là dạng nội dung nên có nếu anh muốn website phát triển giống Traveloka hay Booking về mặt khám phá và tối ưu tìm kiếm.
                    </p>
                </div>

                <span class="inline-flex rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-700">
                    Blog / Cẩm nang sẽ tiếp tục tách thành page riêng ở bước sau
                </span>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach($newsItems as $item)
                    <article class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                        <div class="h-56 overflow-hidden">
                            <img
                                src="{{ $item['image'] }}"
                                alt="{{ $item['title'] }}"
                                class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                loading="lazy"
                            >
                        </div>

                        <div class="p-6">
                            <h3 class="text-2xl font-extrabold leading-tight text-slate-900">
                                {{ $item['title'] }}
                            </h3>
                            <p class="mt-4 text-sm leading-7 text-slate-600">
                                {{ $item['desc'] }}
                            </p>
                            <span class="mt-6 inline-flex rounded-2xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700">
                                Đọc thêm sau
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-[2.5rem] bg-slate-950 px-6 py-10 text-white sm:px-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_0.8fr] lg:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-300">
                        Đã sẵn sàng cho chuyến đi của bạn?
                    </p>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">
                        Tìm phòng phù hợp hoặc tra cứu booking chỉ trong vài cú nhấp chuột
                    </h2>
                    <p class="mt-4 max-w-2xl text-slate-300">
                        Trang chủ mới không chỉ đẹp hơn mà còn có nhiều nội dung hơn để giữ người dùng ở lại lâu hơn, tăng độ tin cậy và tạo nền tốt cho SEO sau này.
                    </p>
                </div>

                <div class="flex flex-wrap gap-4 lg:justify-end">
                    <a
                        href="{{ route('public.rooms.index') }}"
                        class="rounded-2xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600"
                    >
                        Khám phá phòng
                    </a>

                    <a
                        href="{{ route('public.bookings.lookup') }}"
                        class="rounded-2xl border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/20"
                    >
                        Tra cứu booking
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>