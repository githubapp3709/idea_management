@extends('layouts.app')

@section('title', 'Teams Management')
@section('page-title', 'Teams')

@section('content')

{{-- Top Section --}}
<div class="flex justify-between items-center mb-6">

    <a href="{{ route('teams.create') }}"
        class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
        + Create Team
    </a>

    <input type="text"
        placeholder="Search teams..."
        class="border rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring w-64">
</div>


{{-- Teams Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

    @foreach($teams as $team)
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

        {{-- Gradient Header --}}
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-4 text-white flex justify-between items-center">
            <h3 class="font-semibold text-lg">
                {{ $team->name }}
            </h3>

            {{-- Icon --}}
            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                
                    <img src="{{ $team->image_url}}" class="rounded-full">
         
            </div>

        </div>

        {{-- Card Body --}}
        <div class="p-4 space-y-4">

            {{-- Members Count --}}
            <div class="text-sm text-gray-500">
                👥 <strong>{{ $team->members->count() }}</strong> Members
            </div>

            {{-- Leader Info --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                    {{ strtoupper(substr($team->leader?->name ?? 'NA', 0, 1)) }}
                </div>

                <div class="text-sm">
                    <div class="font-medium">
                        {{ $team->leader?->name ?? 'No Leader Assigned' }}
                    </div>
                    <div class="text-gray-400 text-xs">
                        Team created {{ $team->created_at->format('M d, Y') }}
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-2 pt-3 border-t">

                {{-- View --}}
                <a href="{{ route('teams.show', $team) }}"
                    class="flex items-center gap-1 px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                    👁 View
                </a>

                {{-- Edit --}}
                <a href="{{ route('teams.edit', $team) }}"
                    class="flex items-center gap-1 px-3 py-1 text-sm bg-indigo-50 text-indigo-600 rounded hover:bg-indigo-100 transition">
                    ✏ Edit
                </a>

                {{-- Delete --}}
                <form method="POST"
                    action="{{ route('teams.destroy', $team) }}"
                    onsubmit="return confirm('Are you sure you want to delete this team?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="flex items-center gap-1 px-3 py-1 text-sm bg-red-50 text-red-600 rounded hover:bg-red-100 transition">
                        🗑 Delete
                    </button>
                </form>

            </div>
        </div>
    </div>
    @endforeach

</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $teams->links() }}
</div>

@endsection