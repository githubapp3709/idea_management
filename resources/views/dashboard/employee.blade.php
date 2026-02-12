@extends('layouts.app')

@section('title', 'My Dashboard')
@section('page-title', 'My Dashboard')

@section('content')

<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="card">My Ideas<br><strong>{{ $data['stats']['total_ideas'] }}</strong></div>
    <div class="card">Pending<br><strong>{{ $data['stats']['pending'] }}</strong></div>
    <div class="card">Approved<br><strong>{{ $data['stats']['approved'] }}</strong></div>
    <div class="card">My Points<br><strong>{{ $data['stats']['reward_points'] }}</strong></div>
</div>

<div class="card">
    <h3 class="font-semibold mb-4">Recent Ideas</h3>

    @foreach($data['recent_ideas'] as $idea)
        <p>
            {{ $idea->title }}
            <span class="text-sm text-gray-500">
                ({{ ucfirst($idea->status->value) }})
            </span>
        </p>
    @endforeach
</div>

@endsection
