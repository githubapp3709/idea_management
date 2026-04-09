<ul class="space-y-2 px-4">
    <li><a href="{{ route('dashboard') }}" class="menu flex items-center gap-2 {{ request()->routeIs('dashboard') 
                ? 'bg-indigo-200 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">
            <img src="{{ asset('images/dashboard.png') }}" alt="">
            <span>Dashboard</span></a>
    </li>
    <li><a href="{{ route('ideas.index') }}" class="menu flex items-center gap-2 {{ request()->routeIs('ideas.index') 
                ? 'bg-indigo-200 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">
            <img src="{{ asset('images/idea_user.png') }}" alt="">
            My Ideas</a>
    </li>
    <li><a href="{{ route('ideas.create') }}" class="menu flex items-center gap-2 {{ request()->routeIs('ideas.create') 
                ? 'bg-indigo-200 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">
            <img src="{{ asset('images/submit idea.png') }}" alt="">
            Submit Idea</a>
    </li>

    <li><a href="{{ route('ideas.approved') }}" class="menu flex items-center gap-2 {{ request()->routeIs('ideas.approved') 
                ? 'bg-indigo-200 text-white shadow-md' 
                : 'text-gray-700 hover:bg-gray-100' }}">
            <img src="{{ asset('images/all ideas.png') }}" alt="">
            All Ideas</a>
    </li>


</ul>