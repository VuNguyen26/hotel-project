<div class="relative min-h-screen overflow-hidden bg-slate-950">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(46,196,182,0.18),transparent_30%),radial-gradient(circle_at_bottom_right,rgba(23,63,138,0.30),transparent_36%)]"></div>
    <div class="absolute inset-0 bg-[linear-gradient(135deg,#020617_0%,#0f172a_45%,#111827_100%)] opacity-95"></div>

    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full max-w-5xl overflow-hidden rounded-[32px] border border-white/10 bg-white/95 shadow-[0_35px_90px_rgba(2,6,23,0.45)] backdrop-blur">
            <div class="grid lg:grid-cols-[1.05fr_0.95fr]">
                <div class="hidden lg:flex flex-col justify-between bg-[linear-gradient(145deg,#173F8A_0%,#143374_45%,#0f172a_100%)] px-10 py-10 text-white">
                    <div>
                        <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-white/80">
                            Navara Access
                        </span>

                        <h2 class="mt-6 text-4xl font-semibold leading-tight">
                            Trải nghiệm đăng nhập chỉn chu, đồng bộ và chuyên nghiệp.
                        </h2>

                        <p class="mt-5 max-w-md text-sm leading-7 text-slate-200/90">
                            Khu vực truy cập dành cho quản trị vận hành và tài khoản hệ thống, với giao diện tối giản, hiện đại và phù hợp tone nhận diện của Navara Boutique Hotel.
                        </p>
                    </div>

                    <div class="grid gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-sm font-semibold">Bảo mật đăng nhập</p>
                            <p class="mt-1 text-sm text-slate-200/85">Hỗ trợ xác thực bằng Fortify và các tính năng bảo mật đi kèm của Jetstream.</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <p class="text-sm font-semibold">Thiết kế đồng bộ</p>
                            <p class="mt-1 text-sm text-slate-200/85">Màu sắc và cảm giác giao diện được tinh chỉnh theo cùng tone với website khách sạn.</p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-8 sm:px-10 sm:py-10">
                    <div class="mb-8 text-center">
                        {{ $logo }}
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>