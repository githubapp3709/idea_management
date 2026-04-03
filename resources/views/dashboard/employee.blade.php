@extends('layouts.app')

@section('title', 'My Dashboard')
@section('page-title', 'My Dashboard')

@section('content')

{{-- Welcome --}}
<div class="mb-6">
    <h2 class="text-2xl font-semibold">
        Welcome back, {{ auth()->user()->name }} 👋
    </h2>
</div>

<form method="GET" class="flex gap-4 mb-6">

    <input type="date" name="from_date" value="{{ request('from_date') }}" class="border px-3 py-2 rounded">

    <input type="date" name="to_date" value="{{ request('to_date') }}" class="border px-3 py-2 rounded">

    <button class="bg-indigo-600 text-white px-4 py-2 rounded">
        Apply
    </button>

    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 rounded">
        Reset
    </a>
 
</form>

{{-- STATS CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">

    <div class="p-5 rounded-xl text-white bg-gradient-to-r from-purple-500 to-indigo-500 shadow">
        <p class="text-sm">My Ideas</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['total_ideas'] }}</h2>
    </div>

    <div class="p-5 rounded-xl text-white bg-gradient-to-r from-lime-900 to-grey-700 shadow">
        <p class="text-sm">Drafts</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['drafts'] }}</h2>
    </div>
    <div class="p-5 rounded-xl text-white bg-gradient-to-r from-orange-400 to-yellow-500 shadow">
        <p class="text-sm">Pending</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['pending'] }}</h2>
    </div>

    <div class="p-5 rounded-xl text-white bg-gradient-to-r from-green-500 to-emerald-500 shadow">
        <p class="text-sm">Approved</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['approved'] }}</h2>
    </div>

    <div class="p-5 rounded-xl text-white bg-gradient-to-r from-pink-500 to-red-500 shadow">
        <p class="text-sm">My Points</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['reward_points'] }}</h2>
    </div>

</div>

{{-- MIDDLE SECTION --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- Performance --}}
    <div class="col-span-2 bg-white rounded-2xl shadow p-6">

        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">My Performance</h3>
        </div>

        <canvas id="performanceChart" height="120"></canvas>

    </div>

    {{-- Recent Ideas --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <div class="flex justify-between mb-4">
            <h3 class="font-semibold text-lg">Recent Ideas</h3>
        </div>

        @foreach($data['recent_ideas'] as $idea)
        <div class="flex items-start gap-3 mb-4">

            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="flex-1">
                <p class="font-medium text-sm">{{ $idea->title }}</p>

                <span class="text-xs px-2 py-1 rounded
                        @if($idea->status->value === 'approved') bg-green-100 text-green-700
                        @elseif($idea->status->value === 'rejected') bg-red-100 text-red-700
                        @elseif($idea->status->value === 'submitted') bg-purple-100 text-purple-700
                        @else bg-yellow-100 text-yellow-700
                        @endif">
                    {{ ucfirst($idea->status->value) }}
                </span>

                <p class="text-xs text-gray-400">
                    {{ $idea->created_at->diffForHumans() }}
                </p>
            </div>

        </div>
        @endforeach

    </div>

</div>

{{-- BOTTOM SECTION --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Summary Cards --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h3 class="font-semibold mb-4">My Summary</h3>

        <div class="grid grid-cols-3 gap-4 text-center">

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
                <strong>{{ $data['stats']['reward_points'] }}</strong>
            </div>

        </div>

    </div>

    {{-- Reward Box --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h3 class="font-semibold mb-4">Reward Points</h3>

        <div class="flex items-center justify-between">

            <div>
                <p class="text-2xl font-bold text-indigo-600">
                    {{ $data['stats']['reward_points'] }}
                </p>
                <p class="text-sm text-gray-500">Total Points Earned</p>
            </div>

            <div class="text-green-500 text-sm font-semibold">
                +{{ rand(10,100) }} this month
            </div>

        </div>

    </div>

</div>

{{-- CHART SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

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

@endsection