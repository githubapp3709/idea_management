@extends('layouts.app')

@section('title', 'Team Details')
@section('page-title', 'Team Details of ' . $team->name)

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

    {{-- TEAM HEADER CARD --}}
    <div class="bg-gradient-to-r from-indigo-200 via-purple-100 to-indigo-100 
                rounded-2xl p-8 shadow">

        <div class="flex justify-between items-center">

            {{-- Left Info --}}
            <div class="flex items-center gap-6">

                {{-- Team Icon --}}
                <div class="w-28 h-28 bg-white rounded-full shadow flex items-center justify-center text-4xl">
                    <img src="{{ $team->image_url}}" class="rounded-full">
                </div>

                <div>
                    <h2 class="text-3xl font-semibold mb-2">
                        {{ $team->name }}
                    </h2>

                    <p class="text-gray-600 text-sm">
                        📅 Created: {{ $team->created_at->format('M d, Y') }}
                    </p>

                    <p class="text-gray-700 mt-2">
                        <strong>Team Lead:</strong>
                        {{ $team->leader?->name ?? 'Not Assigned' }}
                    </p>
                </div>

            </div>

            {{-- Leader Avatar --}}
            @if($team->leader)
            <div class="text-center">
                <div class="w-24 h-24 rounded-full bg-white shadow 
                            flex items-center justify-center text-2xl font-bold">
                    {{ strtoupper(substr($team->leader->name,0,1)) }}
                </div>

                <p class="mt-2 text-sm text-gray-600">
                    Team Lead ⭐
                </p>
            </div>
            @endif

        </div>
    </div>

    {{-- MEMBERS SECTION --}}
    <div class="bg-white rounded-2xl shadow p-8">

        <h3 class="text-2xl font-semibold mb-6">
            Team Members ({{ $members->count() }})
        </h3>

        @if($members->isEmpty())
        <p class="text-gray-500">No members assigned to this team.</p>
        @else

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach($members as $member)

            <div class="bg-gray-50 rounded-xl p-6 text-center shadow hover:shadow-lg transition">

                {{-- Avatar --}}
                <div class="w-20 h-20 mx-auto rounded-full bg-white 
                                shadow flex items-center justify-center 
                                text-xl font-semibold mb-4">
                    {{ strtoupper(substr($member->name,0,1)) }}
                </div>

                <h4 class="font-semibold">
                    {{ $member->name }}
                </h4>

                <p class="text-sm text-gray-500 mt-1">
                    {{ $member->email }}
                </p>

            </div>

            @endforeach

        </div>

        @endif

    </div>

    <div class="mt-6 flex gap-4 ">

        <a href="{{ route('teams.edit', $team) }}"
            class="px-6 py-2 bg-green-600 text-white rounded-lg">
            Edit Team
        </a>
    </div>



</div>

@endsection