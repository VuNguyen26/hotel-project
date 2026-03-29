<nav x-data="{ open: false }">
    {{-- Desktop Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-50 hidden w-72 flex-col border-r border-slate-800 bg-slate-950 text-slate-200 lg:flex">
        <div class="flex h-20 items-center gap-4 border-b border-slate-800 px-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4">
                <div class="rounded-2xl bg-white/5 p-2">
                    <x-application-mark class="block h-10 w-auto" />
                </div>
                <div>
                    <div class="text-lg font-bold tracking-tight text-white">Hotel Admin</div>
                    <div class="text-xs text-slate-400">Management Dashboard</div>
                </div>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-6">
            <div class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">
                Main Menu
            </div>

            <div class="space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <span class="mr-3 text-base">📊</span>
                    Dashboard
                </a>

                <a href="{{ route('room-types.index') }}"
                   class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('room-types.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <span class="mr-3 text-base">🛏️</span>
                    Loại phòng
                </a>

                <a href="{{ route('rooms.index') }}"
                   class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('rooms.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <span class="mr-3 text-base">🚪</span>
                    Phòng
                </a>

                <a href="{{ route('customers.index') }}"
                   class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('customers.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <span class="mr-3 text-base">👥</span>
                    Khách hàng
                </a>

                <a href="{{ route('bookings.index') }}"
                   class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('bookings.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <span class="mr-3 text-base">📅</span>
                    Đặt phòng
                </a>

                <a href="{{ route('payments.index') }}"
                    class="block rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('payments.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    Thanh toán
                </a>
            </div>

            <div class="mt-8 rounded-3xl border border-slate-800 bg-slate-900/80 p-5">
                <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Quick Actions</div>

                <div class="mt-4 space-y-2">
                    <a href="{{ route('rooms.create') }}"
                       class="block rounded-xl bg-white/5 px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-white/10">
                        + Thêm phòng
                    </a>

                    <a href="{{ route('customers.create') }}"
                       class="block rounded-xl bg-white/5 px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-white/10">
                        + Thêm khách hàng
                    </a>

                    <a href="{{ route('bookings.create') }}"
                       class="block rounded-xl bg-blue-600 px-4 py-3 text-sm font-medium text-white transition hover:bg-blue-700">
                        + Tạo booking
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-800 px-4 py-4">
            <a href="{{ route('profile.show') }}"
               class="flex items-center gap-3 rounded-2xl px-4 py-3 transition hover:bg-slate-900">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-sm font-bold text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="truncate text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                    <div class="truncate text-xs text-slate-400">{{ Auth::user()->email }}</div>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit"
                        class="flex w-full items-center rounded-2xl px-4 py-3 text-sm font-medium text-rose-400 transition hover:bg-rose-500/10 hover:text-rose-300">
                    <span class="mr-3">↩</span>
                    Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    {{-- Topbar --}}
    <div class="fixed inset-x-0 top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur lg:left-72">
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
                                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
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
           class="fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto border-r border-slate-800 bg-slate-950 text-slate-200 lg:hidden">
        <div class="flex h-16 items-center justify-between border-b border-slate-800 px-5">
            <div class="text-lg font-bold text-white">Hotel Admin</div>
            <button @click="open = false" class="rounded-xl p-2 text-slate-400 hover:bg-slate-900 hover:text-white">
                ✕
            </button>
        </div>

        <div class="px-4 py-5">
            <div class="space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    Dashboard
                </a>

                <a href="{{ route('room-types.index') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('room-types.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    Loại phòng
                </a>

                <a href="{{ route('rooms.index') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('rooms.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    Phòng
                </a>

                <a href="{{ route('customers.index') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('customers.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    Khách hàng
                </a>

                <a href="{{ route('bookings.index') }}"
                   class="block rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('bookings.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    Đặt phòng
                </a>

                <a href="{{ route('payments.index') }}"
                class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('payments.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <span class="mr-3 text-base">💳</span>
                    Thanh toán
                </a>

            </div>
            
            <div class="mt-8 border-t border-slate-800 pt-5">
                <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                <div class="text-xs text-slate-400">{{ Auth::user()->email }}</div>

                <a href="{{ route('profile.show') }}"
                   class="mt-4 block rounded-2xl bg-white/5 px-4 py-3 text-sm font-medium text-slate-200 hover:bg-white/10">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                            class="block w-full rounded-2xl px-4 py-3 text-left text-sm font-medium text-rose-400 hover:bg-rose-500/10">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </aside>
</nav>