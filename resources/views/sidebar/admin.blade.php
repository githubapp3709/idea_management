<ul class="space-y-2 px-4 mt-6">

    {{-- Dashboard --}}
    <li>
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs('dashboard') 
                ? 'bg-indigo-200 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">
            <img src="{{ asset('images/dashboard.png') }}" alt="">
            <span>Dashboard</span>
        </a> 
    </li>

    {{-- Ideas --}}
    <li>
        <a href="{{ route('ideas.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs('ideas.index') 
                ? 'bg-indigo-200 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">
            <img src="{{ asset('images/submit idea.png') }}" alt="">
            <span>Ideas</span>
        </a>
    </li>

    {{-- Teams --}}
    <li>
        <a href="{{ route('teams.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs('teams.*') 
                ? 'bg-indigo-200 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">
            <img src="{{ asset('images/team.png') }}" alt="">
            <span>Teams</span>
        </a>
    </li>

    {{-- Employees --}}
    <li>
        <a href="{{ route('employees.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs('employees.*') 
                ? 'bg-indigo-200 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">
            <img src="{{ asset('images/employees.png') }}" alt="">
            <span>Employees</span>
        </a>
    </li>

    <li><a href="{{ route('ideas.approved') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs('ideas.approved') 
                ? 'bg-indigo-200 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">
            <img src="{{ asset('images/all ideas.png') }}" alt="">
            <span>All Ideas</span></a>
    </li>


</ul>