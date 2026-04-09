{{-- Overlay (mobile) --}}
<div id="sidebarOverlay"
     class="fixed inset-0 bg-black bg-opacity-50 hidden lg:hidden z-30"
     onclick="toggleSidebar()"></div>

<aside id="sidebar"
    class="app-sidebar fixed top-0 left-0 z-40 w-64 h-screen
           transform -translate-x-full lg:translate-x-0
           transition duration-300 text-white flex flex-col">

    {{-- Logo --}}
    <div class="p-6 text-lg font-bold shrink-0">
        💡 Idea System
    </div>

    {{-- Menu --}}
    <div class="flex-1 overflow-y-auto px-4 pb-6">
        @if(auth()->user()->role->name === 'super_admin')
            @include('sidebar.admin')
        @elseif(auth()->user()->role->name === 'team_lead')
            @include('sidebar.team_lead')
        @else
            @include('sidebar.employee')
        @endif
    </div>

</aside>