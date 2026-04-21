<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Idea Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else

    @endif
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center lg:justify-center flex-col min-h-screen bg-gradient-to-r from-[#0b1f4d] via-[#0a1a3c] to-[#08132b] 
                rounded-3xl px-10 text-white shadow-2xl">
    {{-- <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
            <a
                href="{{ url('/dashboard') }}"
    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
    Dashboard
    </a>
    @else
    <a
        href="{{ route('login') }}"
        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
        Log in
    </a>

    @if (Route::has('register'))
    <a
        href="{{ route('register') }}"
        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
        Register
    </a>
    @endif
    @endauth
    </nav>
    @endif
    </header>
    --}}
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0 ">
        <main>
            <div>
                <div class="grid lg:grid-cols-2 gap-10 items-center py-4">

                    {{-- LEFT CONTENT --}}
                    <div>

                        <span class="bg-gradient-to-r from-blue-500 to-teal-400 
                             px-4 py-1 rounded-full text-xs font-semibold">
                            IDEA MANAGEMENT SYSTEM
                        </span>

                        <h1 class="mt-6 text-4xl lg:text-5xl font-bold leading-tight">
                            Small Ideas Can <br>
                            <span class="text-transparent bg-clip-text 
                                 bg-gradient-to-r from-blue-400 to-green-400">
                                Create Big Changes.
                            </span>
                        </h1>

                        <p class="mt-6 text-gray-300 text-sm lg:text-base leading-relaxed">
                            Share your ideas, suggestions, and feedback in one place. From small improvements to big innovations, every idea you contribute matters and helps shape a better workplace.
                        </p>

                        {{-- FEATURE CARDS --}}
                        <div class="grid sm:grid-cols-3 gap-4 mt-8">

                            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                                <div class="text-xl mb-2">👥</div>
                                <h4 class="font-semibold text-sm">Share Easily</h4>
                                <p class="text-xs text-gray-400 mt-1">
                                    Submit ideas quickly
                                </p>
                            </div>

                            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                                <div class="text-xl mb-2">💬</div>
                                <h4 class="font-semibold text-sm">Collaborate</h4>
                                <p class="text-xs text-gray-400 mt-1">
                                    Discuss & improve ideas
                                </p>
                            </div>

                            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                                <div class="text-xl mb-2">🚀</div>
                                <h4 class="font-semibold text-sm">Innovate</h4>
                                <p class="text-xs text-gray-400 mt-1">
                                    Turn ideas into impact
                                </p>
                            </div>
                        </div>

                        {{-- CTA --}}
                        <div class="mt-8 flex gap-4">

                            <a href="{{ route('register') }}"
                                class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-green-400 
                              text-white font-semibold shadow hover:scale-105 transition">
                                Get Started →
                            </a>

                            <a href="{{ route('login') }}"
                                class="px-6 py-3 rounded-xl border border-white/20 
                              hover:bg-white/10 transition">
                                Login
                            </a>
                        </div>
                    </div>

                    {{-- RIGHT SIDE (VISUAL) --}}
                    <div class="hidden lg:flex justify-center">
                        <img src="{{asset('images/welcome_idea_transparent.png')}}" alt="">
                    </div>

                </div>

            </div>

        </main>
    </div>

    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>