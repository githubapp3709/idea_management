<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Idea System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="theme-default bg-[var(--bg)] text-[var(--text)]">

    <div class="app-layout flex min-h-screen w-full">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main --}}
        <div class="app-main flex-1 flex flex-col min-w-0 lg:ml-64 min-w-0">

            {{-- Topbar --}}
            @include('layouts.topbar')

            {{-- Content --}}
            <main class="app-content p-4 sm:p-6 overflow-y-auto flex-1">

                @if(session('success'))
                <div class="mb-4 p-3 rounded app-alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @yield('content')
            </main>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleUserMenu() {
            document.getElementById('userMenu').classList.toggle('hidden');
        }
    </script>

</body>
</html>