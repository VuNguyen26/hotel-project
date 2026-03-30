<nav x-data="{ open: false }">
    {{-- Desktop Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-50 hidden w-64 flex-col border-r border-white/10 bg-[#163A7D] lg:flex">
        <div class="flex h-20 items-center border-b border-white/10 px-6">
            <a href="{{ route('dashboard') }}" class="block">
                <div class="text-3xl font-extrabold tracking-tight text-white">
                    Nav<span class="text-[#20D3B3]">ara</span>
                </div>
                <div class="mt-1 text-xs font-medium uppercase tracking-[0.22em] text-white/55">
                    Hotel Management
                </div>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto no-scrollbar px-4 py-6">
            <div class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-[0.24em] text-white/45">
                Main Menu
            </div>

            <div class="space-y-1.5">
                <a href="{{ route('dashboard') }}"
                   class="group relative block rounded-2xl px-4 py-3 text-sm font-semibold transition
                   {{ request()->routeIs('dashboard')
                        ? 'bg-white/10 text-white shadow-sm'
                        : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    @if(request()->routeIs('dashboard'))
                        <span class="absolute inset-y-2 left-0 w-1 rounded-r-full bg-[#20D3B3]"></span>
                    @endif
                    Dashboard
                </a>

                <a href="{{ route('room-types.index') }}"
                   class="group relative block rounded-2xl px-4 py-3 text-sm font-semibold transition
                   {{ request()->routeIs('room-types.*')
                        ? 'bg-white/10 text-white shadow-sm'
                        : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    @if(request()->routeIs('room-types.*'))
                        <span class="absolute inset-y-2 left-0 w-1 rounded-r-full bg-[#20D3B3]"></span>
                    @endif
                    Loại phòng
                </a>

                <a href="{{ route('rooms.index') }}"
                   class="group relative block rounded-2xl px-4 py-3 text-sm font-semibold transition
                   {{ request()->routeIs('rooms.*')
                        ? 'bg-white/10 text-white shadow-sm'
                        : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    @if(request()->routeIs('rooms.*'))
                        <span class="absolute inset-y-2 left-0 w-1 rounded-r-full bg-[#20D3B3]"></span>
                    @endif
                    Phòng
                </a>

                <a href="{{ route('customers.index') }}"
                   class="group relative block rounded-2xl px-4 py-3 text-sm font-semibold transition
                   {{ request()->routeIs('customers.*')
                        ? 'bg-white/10 text-white shadow-sm'
                        : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    @if(request()->routeIs('customers.*'))
                        <span class="absolute inset-y-2 left-0 w-1 rounded-r-full bg-[#20D3B3]"></span>
                    @endif
                    Khách hàng
                </a>

                <a href="{{ route('bookings.index') }}"
                   class="group relative block rounded-2xl px-4 py-3 text-sm font-semibold transition
                   {{ request()->routeIs('bookings.*')
                        ? 'bg-white/10 text-white shadow-sm'
                        : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    @if(request()->routeIs('bookings.*'))
                        <span class="absolute inset-y-2 left-0 w-1 rounded-r-full bg-[#20D3B3]"></span>
                    @endif
                    Đặt phòng
                </a>

                <a href="{{ route('payments.index') }}"
                   class="group relative block rounded-2xl px-4 py-3 text-sm font-semibold transition
                   {{ request()->routeIs('payments.*')
                        ? 'bg-white/10 text-white shadow-sm'
                        : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    @if(request()->routeIs('payments.*'))
                        <span class="absolute inset-y-2 left-0 w-1 rounded-r-full bg-[#20D3B3]"></span>
                    @endif
                    Thanh toán
                </a>

                <a href="{{ route('contact-messages.index') }}"
                    class="group relative block rounded-2xl px-4 py-3 text-sm font-semibold transition
                    {{ request()->routeIs('contact-messages.*')
                            ? 'bg-white/10 text-white shadow-sm'
                            : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                        @if(request()->routeIs('contact-messages.*'))
                            <span class="absolute inset-y-2 left-0 w-1 rounded-r-full bg-[#20D3B3]"></span>
                        @endif
                        Liên hệ khách hàng
                    </a>

            </div>

            <div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                <div class="text-[11px] font-semibold uppercase tracking-[0.24em] text-white/45">
                    Quick Actions
                </div>

                <div class="mt-4 space-y-2">
                    <a href="{{ route('rooms.create') }}"
                       class="block rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium text-white/90 transition hover:bg-white/10">
                        Thêm phòng
                    </a>

                    <a href="{{ route('customers.create') }}"
                       class="block rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium text-white/90 transition hover:bg-white/10">
                        Thêm khách hàng
                    </a>

                    <a href="{{ route('bookings.create') }}"
                       class="block rounded-2xl bg-[#20D3B3] px-4 py-3 text-sm font-semibold text-[#163A7D] transition hover:brightness-95">
                        Tạo booking
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 px-4 py-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex w-full items-center justify-center rounded-2xl border border-white/10 px-4 py-3 text-sm font-semibold text-rose-100 transition hover:bg-white/5 hover:text-white">
                    Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    {{-- Topbar --}}
    <div class="fixed inset-x-0 top-0 z-40 border-b border-[#E6EEF5] bg-white/92 backdrop-blur lg:left-64">
        <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <button @click="open = true"
                        class="inline-flex items-center justify-center rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 lg:hidden">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div>
                    <div class="text-sm font-semibold text-slate-900">Hotel Management System</div>
                    <div class="text-xs text-slate-500">Admin Dashboard</div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button type="button"
                                    class="inline-flex items-center gap-2 rounded-xl border border-[#E6EEF5] bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                                {{ Auth::user()->name }}

                                <svg class="h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-xs text-slate-400">
                                Manage Account
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                Profile
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    API Tokens
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-slate-200"></div>

                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Overlay --}}
    <div x-show="open" x-transition.opacity class="fixed inset-0 z-40 bg-slate-950/50 lg:hidden" @click="open = false"></div>

    {{-- Mobile Sidebar --}}
    <aside x-show="open"
           x-transition:enter="transform transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transform transition ease-in duration-200"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 z-50 w-64 overflow-y-auto no-scrollbar border-r border-white/10 bg-[#163A7D] lg:hidden">
        <div class="flex h-16 items-center justify-between border-b border-white/10 px-5">
            <div>
                <div class="text-lg font-semibold text-white">Nav<span class="text-[#20D3B3]">ara</span></div>
                <div class="text-[11px] uppercase tracking-[0.18em] text-white/50">Management</div>
            </div>

            <button @click="open = false" class="rounded-xl p-2 text-white/60 hover:bg-white/10 hover:text-white">
                ✕
            </button>
        </div>

        <div class="px-4 py-5">
            <div class="space-y-1.5">
                <a href="{{ route('dashboard') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    Dashboard
                </a>

                <a href="{{ route('room-types.index') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('room-types.*') ? 'bg-white/10 text-white' : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    Loại phòng
                </a>

                <a href="{{ route('rooms.index') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('rooms.*') ? 'bg-white/10 text-white' : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    Phòng
                </a>

                <a href="{{ route('customers.index') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('customers.*') ? 'bg-white/10 text-white' : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    Khách hàng
                </a>

                <a href="{{ route('bookings.index') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('bookings.*') ? 'bg-white/10 text-white' : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    Đặt phòng
                </a>

                <a href="{{ route('payments.index') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('payments.*') ? 'bg-white/10 text-white' : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    Thanh toán
                </a>

                <a href="{{ route('contact-messages.index') }}"
                    class="block rounded-2xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs('contact-messages.*') ? 'bg-white/10 text-white' : 'text-white/80 hover:bg-white/6 hover:text-white' }}">
                    Liên hệ khách hàng
                </a>
            </div>

            <div class="mt-8 rounded-3xl border border-white/10 bg-white/5 p-4">
                <div class="text-[11px] font-semibold uppercase tracking-[0.24em] text-white/45">
                    Quick Actions
                </div>

                <div class="mt-4 space-y-2">
                    <a href="{{ route('rooms.create') }}"
                       class="block rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium text-white/90 transition hover:bg-white/10">
                        Thêm phòng
                    </a>

                    <a href="{{ route('customers.create') }}"
                       class="block rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-medium text-white/90 transition hover:bg-white/10">
                        Thêm khách hàng
                    </a>

                    <a href="{{ route('bookings.create') }}"
                       class="block rounded-2xl bg-[#20D3B3] px-4 py-3 text-sm font-semibold text-[#163A7D] transition hover:brightness-95">
                        Tạo booking
                    </a>
                </div>
            </div>

            <div class="mt-8 border-t border-white/10 pt-5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full rounded-2xl border border-white/10 px-4 py-3 text-left text-sm font-semibold text-rose-100 hover:bg-white/5">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </aside>
</nav>