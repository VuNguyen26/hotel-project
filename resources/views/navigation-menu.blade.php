<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur shadow-sm">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <x-application-mark class="block h-10 w-auto" />
                <div class="hidden sm:block">
                    <div class="text-sm font-semibold text-slate-900">Hotel Admin</div>
                    <div class="text-xs text-slate-500">Management System</div>
                </div>
            </a>

            <div class="hidden items-center gap-2 lg:flex">
                <a href="{{ route('dashboard') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Dashboard
                </a>

                <a href="{{ route('room-types.index') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('room-types.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Loại phòng
                </a>

                <a href="{{ route('rooms.index') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('rooms.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Phòng
                </a>

                <a href="{{ route('customers.index') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('customers.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Khách hàng
                </a>

                <a href="{{ route('bookings.index') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('bookings.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Đặt phòng
                </a>
            </div>
        </div>

        <div class="hidden items-center sm:flex">
            <div class="relative ms-3">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex items-center rounded-full border-2 border-transparent text-sm transition focus:border-slate-300 focus:outline-none">
                                <img class="h-9 w-9 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                        @else
                            <span class="inline-flex rounded-xl">
                                <button type="button" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                                    {{ Auth::user()->name }}

                                    <svg class="h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        @endif
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

        <div class="flex items-center lg:hidden">
            <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-transition class="border-t border-slate-200 bg-white lg:hidden">
        <div class="space-y-1 px-4 py-4">
            <a href="{{ route('dashboard') }}"
               class="block rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                Dashboard
            </a>

            <a href="{{ route('room-types.index') }}"
               class="block rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('room-types.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                Loại phòng
            </a>

            <a href="{{ route('rooms.index') }}"
               class="block rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('rooms.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                Phòng
            </a>

            <a href="{{ route('customers.index') }}"
               class="block rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('customers.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                Khách hàng
            </a>

            <a href="{{ route('bookings.index') }}"
               class="block rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('bookings.*') ? 'bg-blue-50 text-blue-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                Đặt phòng
            </a>
        </div>

        <div class="border-t border-slate-200 px-4 py-4">
            <div class="mb-3">
                <div class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <a href="{{ route('profile.show') }}" class="block rounded-xl px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-xl px-4 py-2 text-left text-sm font-medium text-red-500 hover:bg-red-50">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>