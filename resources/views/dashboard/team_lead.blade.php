@extends('layouts.app')

@section('title', 'Team Lead Dashboard')
@section('page-title', 'Team Lead Dashboard')

@section('content')

{{-- Welcome --}}
<div class="mb-6">
    <h2 class="text-2xl font-semibold">
        Welcome back, {{ auth()->user()->name }} 👋
    </h2>
</div>

{{-- STATS CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="p-5 rounded-xl text-white bg-gradient-to-r from-purple-500 to-indigo-500 shadow">
        <p class="text-sm">Ideas Submitted</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['total_ideas'] }}</h2>
    </div>

    <div class="p-5 rounded-xl text-white bg-gradient-to-r from-blue-500 to-cyan-500 shadow">
        <p class="text-sm">Team Members</p>
        <h2 class="text-2xl font-bold">{{ count($data['team_members']) }}</h2>
    </div>

    <div class="p-5 rounded-xl text-white bg-gradient-to-r from-pink-500 to-red-500 shadow">
        <p class="text-sm">Reward Points</p>
        <h2 class="text-2xl font-bold">
            {{ collect($data['team_members'])->sum('reward_points') }}
        </h2>
    </div>

    <div class="p-5 rounded-xl text-white bg-gradient-to-r from-orange-400 to-yellow-500 shadow">
        <p class="text-sm">Pending Ideas</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['pending'] }}</h2>
    </div>

</div>

{{-- MIDDLE SECTION --}}


<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- Performance --}}
    <div class="col-span-2 bg-white rounded-2xl shadow p-6">

       <div class="flex justify-between items-center mb-4">

    <h3 class="font-semibold text-lg">My Team's Performance</h3>

    <form method="GET">
        <select name="range"
                onchange="this.form.submit()"
                class="border rounded px-3 py-1 text-sm">

            <option value="6months" {{ request('range') == '6months' ? 'selected' : '' }}>
                Last 6 Months
            </option>

            <option value="30days" {{ request('range') == '30days' ? 'selected' : '' }}>
                Last 30 Days
            </option>

            <option value="7days" {{ request('range') == '7days' ? 'selected' : '' }}>
                Last 7 Days
            </option>

        </select>
    </form>

</div>

        {{-- Chart Placeholder --}}
        <canvas id="performanceChart" height="120"></canvas>

        <div class="grid grid-cols-3 gap-4 mt-4 text-center">

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

    {{-- Recent Ideas --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <div class="flex justify-between mb-4">
            <h3 class="font-semibold text-lg">Recent Ideas</h3>
        </div>

        @foreach($data['recent_ideas'] ?? [] as $idea)
            <div class="mb-4 border-b pb-3">

                <p class="font-medium">{{ $idea->title }}</p>

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

{{-- BOTTOM SECTION --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Team Members --}}
    <div class="col-span-2 bg-white rounded-2xl shadow p-6">

        <div class="flex justify-between mb-4">
            <h3 class="font-semibold text-lg">Team Members</h3>
        </div>

        @foreach($data['team_members'] as $member)
            <div class="flex justify-between items-center mb-4">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>

                    <div>
                        <p class="font-medium">{{ $member->name }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $member->ideas_count ?? 0 }} ideas
                        </p>
                    </div>
                </div>

                <span class="text-sm text-indigo-600">
                    {{ $member->reward_points }} pts
                </span>

            </div>
        @endforeach

    </div>

    {{-- Leaderboard --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h3 class="font-semibold text-lg mb-4">Leaderboard</h3>

        @foreach($data['team_members']->sortByDesc('reward_points') as $index => $member)
            <div class="flex justify-between mb-3">

                <span>
                    {{ $index + 1 }}. {{ $member->name }}
                </span>

                <span class="font-semibold text-indigo-600">
                    {{ $member->reward_points }}
                </span>

            </div>
        @endforeach

    </div>

</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById('performanceChart');

    if (!canvas) {
        console.error('Canvas not found');
        return;
    }

    const ctx = canvas.getContext('2d'); // ✅ IMPORTANT FIX

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($data['chart']['labels']->values()),
            datasets: [{
                label: 'Ideas',
                data: @json($data['chart']['data']->values()),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#6366f1'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

});
</script>