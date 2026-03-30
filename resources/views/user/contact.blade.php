<x-layouts.public
    title="Liên hệ | Hotel Booking"
    metaDescription="Thông tin liên hệ, hỗ trợ cơ bản và giải đáp nhanh cho khách hàng khi sử dụng website Hotel Booking."
>
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Liên hệ</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">
                Kết nối với chúng tôi để được hỗ trợ nhanh hơn
            </h1>
            <p class="mt-5 max-w-3xl text-lg leading-8 text-slate-600">
                Trang liên hệ giúp website đầy đủ hơn về mặt trải nghiệm và SEO, đồng thời tạo cảm giác tin cậy hơn cho người dùng khi cần tìm hiểu thêm về đặt phòng.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="space-y-6">
                <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-2xl font-black text-slate-900">Thông tin liên hệ</h2>

                    <div class="mt-6 space-y-5 text-sm leading-7 text-slate-700">
                        <div>
                            <p class="font-semibold text-slate-500">Địa chỉ</p>
                            <p class="mt-1">{{ $contactInfo['address'] }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-500">Số điện thoại</p>
                            <p class="mt-1">{{ $contactInfo['phone'] }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-500">Email</p>
                            <p class="mt-1">{{ $contactInfo['email'] }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-500">Thời gian hỗ trợ</p>
                            <p class="mt-1">{{ $contactInfo['hours'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-sky-200 bg-sky-50 p-6">
                    <h3 class="text-xl font-black text-slate-900">Bạn có thể bắt đầu từ đây</h3>
                    <div class="mt-5 flex flex-wrap gap-4">
                        <a href="{{ route('public.rooms.index') }}" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Xem phòng
                        </a>
                        <a href="{{ route('public.bookings.lookup') }}" class="rounded-2xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                            Tra cứu booking
                        </a>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-black text-slate-900">Câu hỏi thường gặp</h2>

                <div class="mt-8 space-y-4">
                    @foreach($faqs as $faq)
                        <details class="group rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <summary class="cursor-pointer list-none text-lg font-black text-slate-900">
                                {{ $faq['q'] }}
                            </summary>
                            <p class="mt-4 text-sm leading-7 text-slate-600">
                                {{ $faq['a'] }}
                            </p>
                        </details>
                    @endforeach
                </div>

                <div class="mt-8 rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm leading-7 text-slate-600">
                    Hiện tại trang liên hệ này đang đóng vai trò như một trang thông tin và hỗ trợ cơ bản để hoàn thiện website kiểu OTA/hotel booking. Về sau anh có thể nâng cấp thêm form gửi liên hệ thật, Google Map nhúng, social links và schema LocalBusiness để tăng SEO địa phương.
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>