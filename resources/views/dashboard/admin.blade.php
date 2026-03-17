@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- ================= IDEA STATS ================= --}}
    <div>
        <h2 class="text-lg font-semibold mb-4">Ideas Overview</h2>

        <div class="grid grid-cols-6 gap-4">

            <div class="bg-indigo-500 text-white p-5 rounded-xl shadow">
                <p>Total</p>
                <h3 class="text-2xl font-bold">{{ $data['stats']['total_ideas'] }}</h3>
            </div>

            <div class="bg-gray-500 text-white p-5 rounded-xl shadow">
                <p>Draft</p>
                
            </div>

            <div class="bg-purple-500 text-white p-5 rounded-xl shadow">
                <p>Submitted</p>
                
            </div>

            <div class="bg-green-500 text-white p-5 rounded-xl shadow">
                <p>Approved</p>
                
            </div>

            <div class="bg-red-500 text-white p-5 rounded-xl shadow">
                <p>Rejected</p>
                <h3 class="text-2xl font-bold">{{ $data['stats']['rejected_ideas'] }}</h3>
            </div>

            <div class="bg-yellow-500 text-white p-5 rounded-xl shadow">
                <p>Approval Rate</p>
               
            </div>

        </div>
    </div>

    {{-- ================= EMPLOYEE STATS ================= --}}
    <div>
        <h2 class="text-lg font-semibold mb-4">Employees</h2>

        <div class="grid grid-cols-6 gap-4">

          

        </div>
    </div>

    {{-- ================= MAIN GRID ================= --}}
    <div class="grid grid-cols-3 gap-8">

        {{-- LEFT SIDE --}}
        <div class="col-span-2 space-y-6">

            {{-- Recent Ideas --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <div class="flex justify-between mb-4">
                    <h3 class="font-semibold">Recent Ideas</h3>
                    <a href="{{ route('ideas.index') }}" class="text-sm text-indigo-600">View All</a>
                </div>

               
            </div>

        </div>

        {{-- RIGHT SIDE --}}
        <div class="space-y-6">

            {{-- Top Contributors --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold mb-4">Top Contributors</h3>

                @foreach($data['top_contributors'] as $user)
                    <div class="flex justify-between py-2">
                        <span>{{ $user->name }}</span>
                        <span class="text-indigo-600 text-sm">
                            {{ $user->reward_points }} pts
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Top Teams --}}
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="font-semibold mb-4">Top Teams</h3>

                @foreach($data['top_teams'] as $team)
                    <div class="flex justify-between py-2">
                        <span>{{ $team->name }}</span>
                        <span class="text-green-600 text-sm">
                            {{ $team->total_points ?? 0 }} pts
                        </span>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

</div>

@endsection