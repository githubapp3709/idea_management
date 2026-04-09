@extends('layouts.app')

@section('title', 'Team Lead Dashboard')
@section('page-title', 'Team Lead Dashboard')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- ================= WELCOME ================= --}}
    <div class="mb-6">
        <h2 class="text-xl sm:text-2xl font-semibold">
            Welcome back, {{ auth()->user()->name }} 👋
        </h2>
    </div>

    {{-- ================= FILTER ================= --}}
    <form method="GET" class="grid grid-cols-2 sm:flex gap-3 mb-6">

        <input type="date"
            name="from_date"
            value="{{ request('from_date') }}"
            class="border px-3 py-2 rounded w-full">

        <input type="date"
            name="to_date"
            value="{{ request('to_date') }}"
            class="border px-3 py-2 rounded w-full">

        <div class="col-span-2 flex gap-3">
            <button class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded">
                Apply
            </button>

            <a href="{{ route('dashboard') }}"
                class="flex-1 px-4 py-2 bg-gray-200 rounded text-center">
                Reset
            </a>
        </div>

    </form>

    {{-- ================= STATS ================= --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">

        <div class="p-4 sm:p-5 rounded-xl text-white bg-gradient-to-r from-blue-500 to-cyan-500 shadow flex items-center justify-between">
            <div>
            <p class="text-sm">Team Members</p>
            <h2 class="text-xl sm:text-2xl font-bold">{{ count($data['team_members']) }}</h2>
            </div>
            <div class="p-2 bg-blue-200 rounded shrink-0">
                <img src="{{ asset('images/users.png') }}" alt="">
            </div>
        </div>

        <div class="p-4 sm:p-5 rounded-xl text-white bg-gradient-to-r from-purple-500 to-indigo-500 shadow flex items-center justify-between">
            <div>
            <p class="text-sm">Total Ideas</p>
            <h2 class="text-xl sm:text-2xl font-bold">{{ $data['stats']['total_ideas'] }}</h2>
            </div>
            <div class="p-2 bg-purple-200 rounded shrink-0">
                <img src="{{ asset('images/total idea.png') }}" alt="">
            </div>
        </div>

        <div class="p-4 sm:p-5 rounded-xl text-white bg-gradient-to-r from-pink-500 to-red-500 shadow flex items-center justify-between">
            <div>
            <p class="text-sm">Reward Points</p>
            <h2 class="text-xl sm:text-2xl font-bold">
                {{ collect($data['team_members'])->sum('reward_points') }}
            </h2>
            </div>
            <div class="p-2 bg-pink-200 rounded shrink-0">
                <img src="{{ asset('images/points.png') }}" alt="">
            </div>
        </div>


        <div class="p-4 sm:p-5 rounded-xl text-white bg-gradient-to-r from-green-500 to-yellow-500 shadow flex items-center justify-between">
            <div>
            <p class="text-sm">Approved</p>
            <h2 class="text-xl sm:text-2xl font-bold">{{ $data['stats']['approved'] }}</h2>
            </div>
            <div class="p-2 bg-yellow-200 rounded shrink-0">
                <img src="{{ asset('images/approved.png') }}" alt="">
            </div>
        </div>

        <div class="p-4 sm:p-5 rounded-xl text-white bg-gradient-to-r from-red-500 to-yellow-500 shadow flex items-center justify-between">
            <div>
            <p class="text-sm">Rejected</p>
            <h2 class="text-xl sm:text-2xl font-bold">{{ $data['stats']['rejected'] }}</h2>
            </div>
            <div class="p-2 bg-red-200 rounded shrink-0">
                <img src="{{ asset('images/rejected.png') }}" alt="">
            </div>
        </div>

        <div class="p-4 sm:p-5 rounded-xl text-white bg-gradient-to-r from-orange-400 to-yellow-500 shadow flex items-center justify-between">
            <div>
            <p class="text-sm">Submitted</p>
            <h2 class="text-xl sm:text-2xl font-bold">{{ $data['stats']['pending'] }}</h2>
            </div>
            <div class="p-2 bg-yellow-200 rounded shrink-0">
                <img src="{{ asset('images/submitted.png') }}" alt="">
            </div>
        </div>

    </div>



    {{-- ================= MIDDLE ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">

        {{-- PERFORMANCE --}}
        <div class="col-span-1 lg:col-span-2 bg-white rounded-2xl shadow p-4 sm:p-6">

            <h3 class="font-semibold text-base sm:text-lg mb-4">
                My Team's Performance
            </h3>

            <canvas id="performanceChart" class="w-full h-48 sm:h-64"></canvas>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mt-4 text-center">

                <div class="bg-purple-50 p-3 rounded">
                    <p class="text-sm">Ideas</p>
                    <strong>{{ $data['stats']['total_ideas'] }}</strong>
                </div>

                <div class="bg-green-50 p-3 rounded">
                    <p class="text-sm">Approved</p>
                    <strong>{{ $data['stats']['approved'] }}</strong>
                </div>

                <div class="bg-yellow-50 p-3 rounded">
                    <p class="text-sm">Points</p>
                    <strong>
                        {{ collect($data['team_members'])->sum('reward_points') }}
                    </strong>
                </div>

            </div>

        </div>

        {{-- RECENT IDEAS --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-6">

            <h3 class="font-semibold text-base sm:text-lg mb-4">Recent Ideas</h3>

            @foreach($data['recent_ideas'] ?? [] as $idea)
            <div class="mb-4 border-b pb-3">

                <p class="font-medium text-sm sm:text-base">
                    {{ $idea->title }}
                </p>

                <span class="text-xs px-2 py-1 rounded
                    @if($idea->status->value === 'approved') bg-green-100 text-green-700
                    @elseif($idea->status->value === 'rejected') bg-red-100 text-red-700
                    @elseif($idea->status->value === 'submitted') bg-purple-100 text-purple-700
                    @else bg-yellow-100 text-yellow-700
                    @endif">

                    {{ ucfirst($idea->status->value) }}
                </span>

                <p class="text-xs text-gray-400 mt-1">
                    {{ $idea->created_at->diffForHumans() }}
                </p>

            </div>
            @endforeach

        </div>

    </div>

    {{-- ================= BOTTOM ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">

        {{-- TEAM MEMBERS --}}
        <div class="col-span-1 lg:col-span-2 bg-white rounded-2xl shadow p-4 sm:p-6">

            <h3 class="font-semibold text-base sm:text-lg mb-4">Team Members</h3>

            @foreach($data['team_members'] as $member)
           
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-4">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        {{ strtoupper(substr($member['name'], 0, 1)) }}
                    </div>

                    <div>
                        <p class="font-medium text-sm sm:text-base">
                            {{ $member['name'] }}
                        </p>
                        <p class="text-xs text-gray-400">
                            {{ $member['total_ideas'] ?? 0 }} ideas
                        </p>
                    </div>
                </div>

                <span class="text-sm text-indigo-600">
                    {{ $member['total_points'] }} pts
                </span>

            </div>
            @endforeach

        </div>

        {{-- LEADERBOARD --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-6">

            <h3 class="font-semibold text-base sm:text-lg mb-4">Leaderboard</h3>

            @foreach($data['team_members']->sortByDesc('reward_points') as $index => $member)
            <div class="flex justify-between mb-3 text-sm sm:text-base">

                <span>
                    {{ $index + 1 }}. {{ $member['name'] }}
                </span>

                <span class="font-semibold text-indigo-600">
                    {{ $member['total_points'] }}
                </span>

            </div>
            @endforeach

        </div>

    </div>

</div>

@endsection


{{-- ================= CHART ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById('performanceChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($data['chart']['labels'] ?? []),
            datasets: [{
                label: 'Ideas',
                data: @json($data['chart']['data'] ?? []),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                fill: true,
                tension: 0.4
            }]
        }
    });
});
</script>