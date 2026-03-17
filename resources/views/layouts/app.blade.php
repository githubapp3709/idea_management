<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Idea System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main --}}
        <div class="flex-1 flex flex-col">

            {{-- Topbar --}}
            @include('layouts.topbar')

            {{-- Content --}}
            <main class="p-6 overflow-y-auto ">
                @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
                @endif
                @yield('content')
            </main>

        </div>
    </div>

</body>

</html>