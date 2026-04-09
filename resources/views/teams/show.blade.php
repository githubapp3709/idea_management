@extends('layouts.app')

@section('title', 'Team Details')
@section('page-title', 'Team Details of ' . $team->name)

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- ================= TEAM HEADER ================= --}}
    <div class="bg-gradient-to-r from-indigo-200 via-purple-100 to-indigo-100 
                rounded-2xl p-4 sm:p-6 lg:p-8 shadow">

        <div class="flex flex-col lg:flex-row lg:justify-between gap-6">

            {{-- LEFT --}}
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6 text-center sm:text-left">

                {{-- Team Image --}}
                <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 
                            bg-white rounded-full shadow flex items-center justify-center overflow-hidden shrink-0">
                    <img src="{{ $team->image_url }}" class="w-full h-full object-cover rounded-full">
                </div>

                {{-- Info --}}
                <div>
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold mb-2">
                        {{ $team->name }}
                    </h2>

                    <p class="text-gray-600 text-sm">
                        📅 {{ $team->created_at->format('M d, Y') }}
                    </p>

                    <p class="text-gray-700 mt-2 text-sm sm:text-base">
                        <strong>Team Lead:</strong>
                        {{ $team->leader?->name ?? 'Not Assigned' }}
                    </p>
                </div>

            </div>

            {{-- LEADER --}}
            @if($team->leader)
            <div class="text-center self-center lg:self-start">
                <div class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 
                            rounded-full bg-white shadow flex items-center justify-center text-lg sm:text-xl font-bold">
                    {{ strtoupper(substr($team->leader->name,0,1)) }}
                </div>

                <p class="mt-2 text-xs sm:text-sm text-gray-600">
                    Team Lead ⭐
                </p>
            </div>
            @endif

        </div>
    </div>

    {{-- ================= MEMBERS ================= --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-6 lg:p-8">

        <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold mb-4 sm:mb-6">
            Team Members ({{ $members->count() }})
        </h3>

        @if($members->isEmpty())
            <p class="text-gray-500 text-sm">No members assigned to this team.</p>
        @else

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">

            @foreach($members as $member)

            <div class="bg-gray-50 rounded-xl p-4 sm:p-6 text-center shadow hover:shadow-lg transition">

                {{-- Avatar --}}
                <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-full bg-white 
                            shadow flex items-center justify-center 
                            text-lg sm:text-xl font-semibold mb-3 sm:mb-4">
                    {{ strtoupper(substr($member->name,0,1)) }}
                </div>

                <h4 class="font-semibold text-sm sm:text-base truncate">
                    {{ $member->name }}
                </h4>

                <p class="text-xs sm:text-sm text-gray-500 mt-1 truncate">
                    {{ $member->email }}
                </p>

            </div>

            @endforeach

        </div>

        @endif

    </div>

    {{-- ================= ACTION ================= --}}
    <div class="flex flex-col sm:flex-row gap-3">

        <a href="{{ route('teams.edit', $team) }}"
            class="w-full sm:w-auto text-center px-6 py-2 bg-green-600 text-white rounded-lg">
            Edit Team
        </a>

    </div>

</div>

@endsection