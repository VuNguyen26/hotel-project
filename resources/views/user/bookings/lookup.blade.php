<x-layouts.public title="Tra cứu booking">
    <section class="border-b border-slate-200 bg-white">
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">
                Tra cứu booking
            </p>

            <h1 class="mt-3 text-4xl font-extrabold tracking-tight text-slate-900">
                Kiểm tra lại thông tin đặt phòng của bạn
            </h1>

            <p class="mt-4 max-w-3xl text-lg text-slate-600">
                Nhập mã booking cùng email hoặc số điện thoại đã dùng khi đặt phòng để xem lại trạng thái và chi tiết booking.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-700">
                    <p class="font-semibold">Vui lòng kiểm tra lại thông tin:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('public.bookings.lookup.submit') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Mã booking <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="booking_code"
                        value="{{ old('booking_code') }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm uppercase focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                        placeholder="Ví dụ: BK-20260330-000123"
                    >
                    <p class="mt-2 text-xs text-slate-500">
                        Bạn có thể nhập đúng mã booking đã được hệ thống cấp sau khi đặt phòng.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                            placeholder="Nhập email đã đặt phòng"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Số điện thoại
                        </label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200"
                            placeholder="Nhập số điện thoại đã đặt phòng"
                        >
                    </div>
                </div>

                <div class="rounded-2xl border border-sky-200 bg-sky-50 p-4 text-sm leading-6 text-sky-900">
                    Bạn chỉ cần nhập <strong>email hoặc số điện thoại</strong>. Nếu nhập cả hai, hệ thống sẽ kiểm tra đồng thời cả hai thông tin.
                </div>

                <div class="flex flex-wrap gap-4">
                    <button
                        type="submit"
                        class="rounded-2xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600"
                    >
                        Tra cứu booking
                    </button>

                    <a
                        href="{{ route('home') }}"
                        class="rounded-2xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        Về trang chủ
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layouts.public>