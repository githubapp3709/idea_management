<header class="app-header bg-[var(--card)] shadow px-4 sm:px-6 py-4 flex justify-between items-center">

    <div class="flex items-center gap-3">

        {{-- Mobile Menu Button --}}
        <button onclick="toggleSidebar()" class="lg:hidden text-gray-600">
            ☰
        </button>

        <h1 class="text-lg sm:text-xl font-semibold">
            @yield('page-title', 'Dashboard')
        </h1>
    </div>

    <div class="flex items-center gap-4 sm:gap-6">

        {{-- Notifications --}}
        <a href="{{ route('notifications.index') }}" class="relative">
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11
                         a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341
                         C7.67 6.165 6 8.388 6 11v3.159
                         c0 .538-.214 1.055-.595 1.436L4 17h5" />
            </svg>

            @if(auth()->user()->unreadNotifications->count())
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </a>

        {{-- User --}}
        <div class="relative">
            <button onclick="toggleUserMenu()" class="flex items-center gap-1 text-sm">
                {{ auth()->user()->name }}
            </button>

            <div id="userMenu"
                 class="hidden absolute right-0 mt-2 w-32 bg-[var(--card)] border rounded shadow">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>