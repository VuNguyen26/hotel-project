<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Admin / Contact Messages</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">
                Danh sách liên hệ khách hàng
            </h1>
            <p class="mt-2 text-sm leading-7 text-slate-600">
                Theo dõi các tin nhắn được gửi từ trang liên hệ trên user side.
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">Tổng tin nhắn</p>
                <p class="mt-3 text-3xl font-black text-slate-900">{{ number_format($stats['total']) }}</p>
            </div>

            <div class="rounded-3xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
                <p class="text-sm font-semibold text-amber-700">Chưa đọc</p>
                <p class="mt-3 text-3xl font-black text-amber-800">{{ number_format($stats['unread']) }}</p>
            </div>

            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm">
                <p class="text-sm font-semibold text-emerald-700">Đã đọc</p>
                <p class="mt-3 text-3xl font-black text-emerald-800">{{ number_format($stats['read']) }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <form method="GET" action="{{ route('contact-messages.index') }}" class="grid gap-4 lg:grid-cols-[1fr_220px_160px]">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Tìm kiếm</label>
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Tên, email, số điện thoại, chủ đề..."
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-slate-400 focus:outline-none"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Trạng thái</label>
                    <select
                        name="status"
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 focus:border-slate-400 focus:outline-none"
                    >
                        <option value="">Tất cả</option>
                        <option value="unread" @selected(request('status') === 'unread')>Chưa đọc</option>
                        <option value="read" @selected(request('status') === 'read')>Đã đọc</option>
                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button
                        type="submit"
                        class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
                    >
                        Lọc
                    </button>
                    <a
                        href="{{ route('contact-messages.index') }}"
                        class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Khách hàng</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Chủ đề</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Liên hệ</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Trạng thái</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Thời gian</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($messages as $message)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-5 align-top">
                                    <div class="font-bold text-slate-900">{{ $message->full_name }}</div>
                                    <div class="mt-1 text-sm text-slate-500">#{{ $message->id }}</div>
                                </td>

                                <td class="px-6 py-5 align-top">
                                    <div class="font-semibold text-slate-900">{{ $message->subject }}</div>
                                    <div class="mt-2 line-clamp-2 max-w-md text-sm leading-7 text-slate-600">
                                        {{ $message->message }}
                                    </div>
                                </td>

                                <td class="px-6 py-5 align-top text-sm text-slate-600">
                                    <div>{{ $message->phone ?: '—' }}</div>
                                    <div class="mt-1">{{ $message->email ?: '—' }}</div>
                                </td>

                                <td class="px-6 py-5 align-top">
                                    @if($message->is_read)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            Đã đọc
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                            Chưa đọc
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 align-top text-sm text-slate-600">
                                    {{ $message->created_at?->format('d/m/Y H:i') }}
                                </td>

                                <td class="px-6 py-5 align-top">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route('contact-messages.show', $message) }}"
                                            class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                        >
                                            Xem
                                        </a>

                                        @if(!$message->is_read)
                                            <form method="POST" action="{{ route('contact-messages.read', $message) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700"
                                                >
                                                    Đã đọc
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    Chưa có tin nhắn liên hệ nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($messages->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>