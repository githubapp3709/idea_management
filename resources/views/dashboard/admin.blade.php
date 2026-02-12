@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')

<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="card">
        <p class="text-gray-500">Total Ideas</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['total_ideas'] }}</h2>
    </div>

    <div class="card">
        <p class="text-gray-500">Pending</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['pending_ideas'] }}</h2>
    </div>

    <div class="card">
        <p class="text-gray-500">Approved</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['approved_ideas'] }}</h2>
    </div>

    <div class="card">
        <p class="text-gray-500">Rejected</p>
        <h2 class="text-2xl font-bold">{{ $data['stats']['rejected_ideas'] }}</h2>
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    <div class="card">
        <h3 class="font-semibold mb-4">Top Contributors</h3>
        @foreach($data['top_contributors'] as $user)
            <p>{{ $user->name }} — {{ $user->reward_points }} pts</p>
        @endforeach
    </div>

    <div class="card">
        <h3 class="font-semibold mb-4">Top Teams</h3>
        @foreach($data['top_teams'] as $team)
            <p>{{ $team->name }} — {{ $team->total_points }} pts</p>
        @endforeach
    </div>
</div>

@endsection
