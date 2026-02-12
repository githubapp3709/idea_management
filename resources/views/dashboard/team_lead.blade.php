@extends('layouts.app')

@section('title', 'Team Dashboard')
@section('page-title', 'Team Dashboard')

@section('content')

<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="card">Total Ideas<br><strong>{{ $data['stats']['total_ideas'] }}</strong></div>
    <div class="card">Pending<br><strong>{{ $data['stats']['pending'] }}</strong></div>
    <div class="card">Approved<br><strong>{{ $data['stats']['approved'] }}</strong></div>
    <div class="card">Rejected<br><strong>{{ $data['stats']['rejected'] }}</strong></div>
</div>

<div class="card">
    <h3 class="font-semibold mb-4">Team Leaderboard</h3>

    @foreach($data['team_members'] as $member)
        <p>{{ $member->name }} — {{ $member->reward_points }} pts</p>
    @endforeach
</div>

@endsection
