<ul class="space-y-2 px-4 mt-6">

    {{-- Dashboard --}}
    <li>
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs('dashboard') 
                ? 'bg-indigo-600 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">

            <svg class="w-5 h-5"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 10l9-7 9 7v11a1 1 0 01-1 1h-6v-6H10v6H4a1 1 0 01-1-1V10z"/>
            </svg>

            <span>Dashboard</span>
        </a>
    </li>

    {{-- Ideas --}}
    <li>
        <a href="{{ route('ideas.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs('ideas.*') 
                ? 'bg-indigo-600 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">

            <svg class="w-5 h-5"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8c-3.866 0-7 2.239-7 5s3.134 5 7 5 7-2.239 7-5-3.134-5-7-5z"/>
            </svg>

            <span>Ideas</span>
        </a>
    </li>

    {{-- Teams --}}
    <li>
        <a href="{{ route('teams.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs('teams.*') 
                ? 'bg-indigo-600 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">

            <svg class="w-5 h-5"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 20h5V4H2v16h5"/>
            </svg>

            <span>Teams</span>
        </a>
    </li>

    {{-- Employees --}}
    <li>
        <a href="{{ route('employees.index') }}"
           class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ request()->routeIs('employees.*') 
                ? 'bg-indigo-600 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">

            <svg class="w-5 h-5"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <span>Employees</span>
        </a>
    </li>

</ul>
