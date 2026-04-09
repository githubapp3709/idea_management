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

{{-- FILTER --}}
<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">

    <input type="date" name="from_date"
        value="{{ request('from_date') }}"
        class="app-input">

    <input type="date" name="to_date"
        value="{{ request('to_date') }}"
        class="app-input">

    <!-- Button Wrapper -->
    <div class="flex gap-3">
        <button class="app-btn-primary sm:w-auto">
            Apply
        </button>

        <a href="{{ route('dashboard') }}"
            class="app-btn-secondary w-full sm:w-auto text-center">
            Reset
        </a>
    </div>
</form>

{{-- STATS CARDS --}}
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-8">

    <div class="app-stat-card flex items-center justify-between bg-gradient-to-r from-purple-500 to-indigo-500">
        <div>
            <p>My Ideas</p>
            <h2>{{ $data['stats']['total_ideas'] }}</h2>
        </div>
        <div class="p-2 bg-purple-200 rounded shrink-0">
            <img src="{{ asset('images/total idea.png') }}" alt="">
        </div>
    </div>

    <div class="app-stat-card flex items-center justify-between bg-gradient-to-r from-gray-600 to-gray-800">
        <div>
            <p>Drafts</p>
            <h2>{{ $data['stats']['drafts'] }}</h2>
        </div>
        <div class="p-2 bg-gray-200 rounded shrink-0">
            <img src="{{ asset('images/draft idea.png') }}" alt="">
        </div>
    </div>

    <div class="app-stat-card flex items-center justify-between bg-gradient-to-r from-orange-400 to-yellow-500">
        <div>
            <p>Submitted</p>
            <h2>{{ $data['stats']['pending'] }}</h2>
        </div>
        <div class="p-2 bg-orange-200 rounded shrink-0">
            <img src="{{ asset('images/submitted.png') }}" alt="">
        </div>
    </div>

    <div class="app-stat-card flex items-center justify-between bg-gradient-to-r from-green-500 to-emerald-500">
        <div>
            <p>Approved</p>
            <h2>{{ $data['stats']['approved'] }}</h2>
        </div>
        <div class="p-2 bg-emerald-200 rounded shrink-0">
            <img src="{{ asset('images/approved.png') }}" alt="">
        </div>
    </div>

    <div class="app-stat-card flex items-center justify-between bg-gradient-to-r from-red-500 to-orange-500">
        <div>
            <p>Rejected</p>
            <h2>{{ $data['stats']['rejected'] }}</h2>
        </div>
        <div class="p-2 bg-red-200 rounded shrink-0">
            <img src="{{ asset('images/rejected.png') }}" alt="">
        </div>
    </div>

    <div class="app-stat-card flex items-center justify-between bg-gradient-to-r from-pink-500 to-red-500">
        <div>
            <p>Points</p>
            <h2>{{ $data['stats']['reward_points'] }}</h2>
        </div>
        <div class="p-2 bg-pink-200 rounded shrink-0">
            <img src="{{ asset('images/approval rate.png') }}" alt="">
        </div>
    </div>

</div>

{{-- MIDDLE SECTION --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- Performance --}}
    <div class="lg:col-span-2 app-card p-4 sm:p-6">

        <h3 class="font-semibold mb-4">My Performance</h3>

        <div class="h-64 sm:h-80">
            <canvas id="performanceChart"></canvas>
        </div>
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
                        {{ $data['stats']['reward_points'] }}
                    </strong>
                </div>

            </div>

    </div>
    {{-- Recent Ideas --}}
    <div class="app-card p-4 sm:p-6">

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