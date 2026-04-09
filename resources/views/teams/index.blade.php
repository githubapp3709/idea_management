@extends('layouts.app')

@section('title', 'Teams Management')
@section('page-title', 'Teams')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- ================= TOP SECTION ================= --}}
    <div class="flex flex-col sm:flex-row sm:justify-between gap-3">

        {{-- Create Button --}}
        <a href="{{ route('teams.create') }}"
            class="w-full sm:w-auto text-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            + Create Team
        </a>

        {{-- Search --}}
        <input type="text"
            placeholder="Search teams..."
            class="border rounded-lg px-4 py-2 text-sm w-full sm:w-64 focus:outline-none focus:ring">
    </div>


    {{-- ================= TEAMS GRID ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

        @foreach($teams as $team)
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col">

            {{-- HEADER --}}
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-4 text-white flex justify-between items-center">

                <h3 class="font-semibold text-base sm:text-lg truncate max-w-[180px]">
                    {{ $team->name }}
                </h3>

                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center overflow-hidden shrink-0">
                    <img src="{{ $team->image_url }}" class="w-full h-full object-cover">
                </div>

            </div>

            {{-- BODY --}}
            <div class="p-4 space-y-4 flex-1">

                {{-- Members --}}
                <div class="text-sm text-gray-500">
                    👥 <strong>{{ $team->members->count() }}</strong> Members
                </div>

                {{-- Leader --}}
                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold shrink-0">
                        {{ strtoupper(substr($team->leader?->name ?? 'NA', 0, 1)) }}
                    </div>

                    <div class="text-sm min-w-0">
                        <div class="font-medium truncate">
                            {{ $team->leader?->name ?? 'No Leader Assigned' }}
                        </div>

                        <div class="text-gray-400 text-xs">
                            {{ $team->created_at->format('M d, Y') }}
                        </div>
                    </div>

                </div>

                {{-- ACTIONS --}}
                <div class="flex flex-wrap gap-2 pt-3 border-t">

                    {{-- View --}}
                    <a href="{{ route('teams.show', $team) }}"
                        class="flex-1 sm:flex-none text-center px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                        👁 View
                    </a>

                    {{-- Edit --}}
                    <a href="{{ route('teams.edit', $team) }}"
                        class="flex-1 sm:flex-none text-center px-3 py-1 text-sm bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100 transition">
                        ✏ Edit
                    </a>

                    {{-- Delete --}}
                    <form method="POST"
                        action="{{ route('teams.destroy', $team) }}"
                        onsubmit="return confirm('Are you sure you want to delete this team?')"
                        class="flex-1 sm:flex-none">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="w-full text-center px-3 py-1 text-sm bg-red-50 text-red-600 rounded hover:bg-red-100 transition">
                            🗑 Delete
                        </button>

                    </form>

                </div>

            </div>

        </div>
        @endforeach

    </div>

    {{-- ================= PAGINATION ================= --}}
    <div>
        {{ $teams->links() }}
    </div>

</div>

@endsection