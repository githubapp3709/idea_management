@extends('layouts.app')

@section('title', 'View User')
@section('page-title', 'View User')

@section('content')

<div class="max-w-6xl mx-auto space-y-8">

    {{-- HEADER CARD --}}
    <div class="bg-gradient-to-r from-indigo-200 via-purple-100 to-indigo-100 
                rounded-2xl p-8 shadow">

        <div class="flex justify-between items-center">

            <div class="flex items-center gap-6">

                {{-- Profile Image --}}
                <div class="w-32 h-32 rounded-full overflow-hidden shadow">
                    <img src="{{ $user->profile_image_url }}"
                         class="w-full h-full object-cover">
                </div>

                <div>
                    <h2 class="text-3xl font-semibold mb-2">
                        {{ $user->name }}
                    </h2>

                    <p class="text-gray-700">
                        ✉ {{ $user->email }}
                    </p>

                    <p class="text-gray-700 mt-1">
                        👤 {{ ucfirst($user->role?->name) }},
                        {{ $user->team?->name ?? 'No Team' }}
                    </p>

                    <p class="text-gray-600 mt-1">
                        📅 Joined on {{ $user->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>

            {{-- Status Toggle --}}
            <div class="text-right">

                <form method="POST"
                      action="{{ route('employees.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden"
                           name="status"
                           value="{{ $user->status === 'active' ? 'inactive' : 'active' }}">

                    <button class="px-6 py-2 rounded-full
                        {{ $user->status === 'active'
                            ? 'bg-green-500 text-white'
                            : 'bg-red-500 text-white' }}">
                        {{ ucfirst($user->status) }}
                    </button>
                </form>

            </div>

        </div>

    </div>

    {{-- STATS SECTION --}}
    <div class="grid grid-cols-3 gap-6">

        <div class="bg-white rounded-xl p-6 shadow text-center">
            <p class="text-gray-500">Team</p>
            <h3 class="text-xl font-semibold mt-2">
                {{ $user->team?->name ?? 'Not Assigned' }}
            </h3>
        </div>

        <div class="bg-white rounded-xl p-6 shadow text-center">
            <p class="text-gray-500">Ideas Submitted</p>
            <h3 class="text-xl font-semibold mt-2">
                {{ $ideasCount }}
            </h3>
        </div>

        <div class="bg-white rounded-xl p-6 shadow text-center">
            <p class="text-gray-500">Reward Points</p>
            <h3 class="text-xl font-semibold mt-2">
                122 Points
            </h3>
        </div>

    </div>

    {{-- FULL INFORMATION --}}
    <div class="bg-white rounded-2xl shadow p-8">

        <h3 class="text-2xl font-semibold mb-6">
            Full Information
        </h3>

        <div class="grid grid-cols-2 gap-6">

            <div>
                <p class="text-gray-500">Full Name</p>
                <p class="font-semibold">{{ $user->name }}</p>
            </div>

            <div>
                <p class="text-gray-500">Employee Code</p>
                <p class="font-semibold">{{ $user->employee_code }}</p>
            </div>

            <div>
                <p class="text-gray-500">Email</p>
                <p class="font-semibold">{{ $user->email }}</p>
            </div>

            <div>
                <p class="text-gray-500">Role</p>
                <p class="font-semibold">{{ ucfirst($user->role?->name) }}</p>
            </div>

            <div>
                <p class="text-gray-500">Join Date</p>
                <p class="font-semibold">
                    {{ $user->created_at->format('M d, Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <p class="font-semibold">
                    {{ ucfirst($user->status) }}
                </p>
            </div>

        </div>

    </div>

</div>

@endsection
