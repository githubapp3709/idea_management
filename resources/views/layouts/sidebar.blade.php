<aside class="w-64 bg-indigo-700 text-white">

    <div class="p-6 text-lg font-bold">
        💡 Idea System
    </div>
    @if(auth()->user()->role->name === 'super_admin')
        @include('sidebar.admin')
    @elseif(auth()->user()->role->name === 'team_lead')
        @include('sidebar.team_lead')
    @else
        @include('sidebar.employee')
    @endif

</aside>
