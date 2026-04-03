@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

{{-- ================= DATE FILTER ================= --}}
<form method="GET" action="{{ route('dashboard') }}" class="flex gap-4 items-center mb-6">

    <div>
        <input type="date"
               name="from_date"
               value="{{ request('from_date') }}"
               class="border px-3 py-2 rounded-lg">
    </div>

    <div>
        <input type="date"
               name="to_date"
               value="{{ request('to_date') }}"
               class="border px-3 py-2 rounded-lg">
    </div>

    <button type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
        Apply
    </button>

    <a href="{{ route('dashboard') }}"
       class="px-4 py-2 bg-gray-200 rounded-lg">
        Reset
    </a>

</form>
    {{-- ================= IDEA STATS ================= --}}
    <div>
        <h2 class="text-lg font-semibold mb-4">Ideas Overview</h2>

        <div class="grid grid-cols-5 gap-4">

            <div class="bg-indigo-500 text-white p-5 rounded-xl shadow">
                <p>Total</p>
                <h3 class="text-2xl font-bold">{{ $data['stats']['total_ideas'] }}</h3>
            </div>

            {{-- <div class="bg-gray-500 text-white p-5 rounded-xl shadow">
                <p>Draft</p>
                <h3 class="text-2xl font-bold">{{ $data['stats']['draft'] }}</h3>
            </div> --}}

            <div class="bg-purple-500 text-white p-5 rounded-xl shadow">
                <p>Submitted</p>
                <h3 class="text-2xl font-bold">{{ $data['stats']['submitted'] }}</h3>
            </div>

            <div class="bg-green-500 text-white p-5 rounded-xl shadow">
                <p>Approved</p>
                <h3 class="text-2xl font-bold">{{ $data['stats']['approved_ideas'] }}</h3>
            </div>

            <div class="bg-red-500 text-white p-5 rounded-xl shadow">
                <p>Rejected</p>
                <h3 class="text-2xl font-bold">{{ $data['stats']['rejected_ideas'] }}</h3>
            </div>

            <div class="bg-yellow-500 text-white p-5 rounded-xl shadow">
                <p>Approval Rate</p>
                <h3 class="text-2xl font-bold">{{ $data['stats']['approval_rate'] }} %</h3>
            </div>

        </div>
    </div>

    {{-- ================= EMPLOYEE STATS ================= --}}
    <div>

        <h2 class="text-lg font-semibold mb-4">Employees</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white p-5 rounded-xl shadow">
                <p class="text-gray-500 text-sm">Total Employees</p>
                <h3 class="text-xl font-bold">{{ $data['employee_stats']['total'] ?? 0 }}</h3>
            </div>

            <div class="bg-green-50 p-5 rounded-xl shadow">
                <p class="text-green-600 text-sm">Active</p>
                <h3 class="text-xl font-bold text-green-700">
                    {{ $data['employee_stats']['active'] ?? 0 }}
                </h3>
            </div>

            <div class="bg-red-50 p-5 rounded-xl shadow">
                <p class="text-red-600 text-sm">Inactive</p>
                <h3 class="text-xl font-bold text-red-700">
                    {{ $data['employee_stats']['inactive'] ?? 0 }}
                </h3>
            </div>

            <div class="bg-blue-50 p-5 rounded-xl shadow">
                <p class="text-blue-600 text-sm">Team Leads</p>
                <h3 class="text-xl font-bold text-blue-700">
                    {{ $data['employee_stats']['team_leads'] ?? 0 }}
                </h3>
            </div>

        </div>

    </div>


    {{-- ================= TEAM OVERVIEW ================= --}}
    <div>
        <h2 class="text-lg font-semibold mb-4">Teams Overview</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($data['teams'] as $team)
            <div class="bg-white rounded-xl shadow p-5 hover:shadow-md transition">

                <div class="flex justify-between items-center mb-3">

                    <h3 class="font-semibold text-lg">
                        {{ $team->name }}
                    </h3>

                    <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded">
                        Team
                    </span>

                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">

                    <div class="bg-gray-50 p-3 rounded text-center">
                        <p class="text-gray-500">Total Ideas</p>
                        <h4 class="font-bold text-lg">
                            {{ $team->ideas_count }}
                        </h4>
                    </div>

                    <div class="bg-green-50 p-3 rounded text-center">
                        <p class="text-green-600">Approved</p>
                        <h4 class="font-bold text-lg text-green-700">
                            {{ $team->approved_ideas_count }}
                        </h4>
                    </div>

                </div>

            </div>
            @endforeach

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

                <table class="min-w-full bg-white shadow rounded border text-center text-sm">

                    {{-- Header --}}
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-center border border-gray-300">#</th>
                            <th class="px-6 py-3 text-center border border-gray-300">Title</th>
                            <th class="px-6 py-3 text-center border border-gray-300">Submitted By</th>
                            <th class="px-6 py-3 text-center border border-gray-300">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                         @foreach($data['recent_ideas'] as $idea)
                         <tr>
                            <td class="text-center border border-gray-300">{{$loop->iteration}}</td>
                            <td class="text-center border border-gray-300">{{ $idea->title }}</td>
                            <td class="text-center border border-gray-300">{{ $idea->submitted_at }}</td>
                            <td class="text-center border border-gray-300">{{ $idea->status }}</td>
                        </tr>                
                @endforeach                        
                       
                    </tbody>
                </table>               
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