<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Admin / Contact Messages / #{{ $contactMessage->id }}</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">
                {{ $contactMessage->subject }}
            </h1>
            <p class="mt-2 text-sm leading-7 text-slate-600">
                Tin nhắn gửi lúc {{ $contactMessage->created_at?->format('d/m/Y H:i') }}
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-3">
            <a
                href="{{ route('contact-messages.index') }}"
                class="rounded-2xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                ← Quay lại danh sách
            </a>

            @if($contactMessage->is_read)
                <form method="POST" action="{{ route('contact-messages.unread', $contactMessage) }}">
                    @csrf
                    @method('PATCH')
                    <button
                        type="submit"
                        class="rounded-2xl border border-amber-300 bg-amber-50 px-5 py-3 text-sm font-semibold text-amber-700 transition hover:bg-amber-100"
                    >
                        Chuyển chưa đọc
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('contact-messages.read', $contactMessage) }}">
                    @csrf
                    @method('PATCH')
                    <button
                        type="submit"
                        class="rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700"
                    >
                        Đánh dấu đã đọc
                    </button>
                </form>
            @endif

            <form method="POST" action="{{ route('contact-messages.destroy', $contactMessage) }}" onsubmit="return confirm('Xóa tin nhắn này?')">
                @csrf
                @method('DELETE')
                <button
                    type="submit"
                    class="rounded-2xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-700"
                >
                    Xóa
                </button>
            </form>
        </div>

        <div class="grid gap-6 xl:grid-cols-[380px_minmax(0,1fr)]">
            <aside class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-xl font-black text-slate-900">Thông tin người gửi</h2>

                        @if($contactMessage->is_read)
                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Đã đọc
                            </span>
                        @else
                            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                Chưa đọc
                            </span>
                        @endif
                    </div>

                    <div class="mt-6 space-y-5 text-sm leading-7 text-slate-700">
                        <div>
                            <p class="font-semibold text-slate-500">Họ và tên</p>
                            <p class="mt-1">{{ $contactMessage->full_name }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-500">Số điện thoại</p>
                            <p class="mt-1">{{ $contactMessage->phone ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-500">Email</p>
                            <p class="mt-1">{{ $contactMessage->email ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-500">Nguồn gửi</p>
                            <p class="mt-1">{{ $contactMessage->source_page ?: 'contact' }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-black text-slate-900">Thông tin kỹ thuật</h2>

                    <div class="mt-6 space-y-5 text-sm leading-7 text-slate-700">
                        <div>
                            <p class="font-semibold text-slate-500">IP Address</p>
                            <p class="mt-1 break-all">{{ $contactMessage->ip_address ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-500">User Agent</p>
                            <p class="mt-1 break-all">{{ $contactMessage->user_agent ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-500">Tạo lúc</p>
                            <p class="mt-1">{{ $contactMessage->created_at?->format('d/m/Y H:i:s') }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-500">Cập nhật lúc</p>
                            <p class="mt-1">{{ $contactMessage->updated_at?->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-2xl font-black text-slate-900">Nội dung liên hệ</h2>

                <div class="mt-6 rounded-[2rem] border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.16em] text-slate-500">Chủ đề</p>
                    <p class="mt-3 text-xl font-black text-slate-900">
                        {{ $contactMessage->subject }}
                    </p>

                    <div class="mt-6 border-t border-slate-200 pt-6">
                        <p class="whitespace-pre-line text-base leading-8 text-slate-700">{{ $contactMessage->message }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>