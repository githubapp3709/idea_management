@extends('layouts.app')

@section('title', 'View User')
@section('page-title', 'View User')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="bg-gradient-to-r from-indigo-200 via-purple-100 to-indigo-100 
                rounded-2xl p-4 sm:p-6 lg:p-8 shadow">

        <div class="flex flex-col lg:flex-row lg:justify-between gap-6">

            {{-- LEFT --}}
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6 text-center sm:text-left">

                {{-- Profile Image --}}
                <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 rounded-full overflow-hidden shadow shrink-0">
                    <img src="{{ $user->profile_image_url }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- Info --}}
                <div>
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold mb-2">
                        {{ $user->name }}
                    </h2>

                    <p class="text-gray-700 text-sm sm:text-base break-all">
                        {{ $user->email }}
                    </p>

                    <p class="text-gray-700 mt-1 text-sm sm:text-base">
                        {{ ucfirst($user->role?->name) }},
                        {{ $user->team?->name ?? 'No Team' }}
                    </p>

                    <p class="text-gray-600 mt-1 text-sm">
                        {{ $user->created_at->format('M d, Y') }}
                    </p>
                </div>

            </div>

            {{-- STATUS --}}
            <div class="self-center lg:self-start text-center lg:text-right">

                <form method="POST"
                      action="{{ route('employees.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden"
                           name="status"
                           value="{{ $user->status === 'active' ? 'inactive' : 'active' }}">

                    <button class="px-5 py-2 sm:px-6 rounded-full text-sm sm:text-base
                        {{ $user->status === 'active'
                            ? 'bg-green-500 text-white'
                            : 'bg-red-500 text-white' }}">
                        {{ ucfirst($user->status) }}
                    </button>
                </form>

            </div>

        </div>

    </div>

    {{-- ================= STATS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">

        <div class="bg-white rounded-xl p-4 sm:p-6 shadow text-center">
            <p class="text-gray-500 text-sm">Team</p>
            <h3 class="text-lg sm:text-xl font-semibold mt-2">
                {{ $user->team?->name ?? 'Not Assigned' }}
            </h3>
        </div>

        <div class="bg-white rounded-xl p-4 sm:p-6 shadow text-center">
            <p class="text-gray-500 text-sm">Ideas Submitted</p>
            <h3 class="text-lg sm:text-xl font-semibold mt-2">
                {{ $ideasCount }}
            </h3>
        </div>

        <div class="bg-white rounded-xl p-4 sm:p-6 shadow text-center">
            <p class="text-gray-500 text-sm">Reward Points</p>
            <h3 class="text-lg sm:text-xl font-semibold mt-2">
                {{$user->reward_points}}
            </h3>
        </div>

    </div>

    {{-- ================= FULL INFO ================= --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-6 lg:p-8">

        <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold mb-4 sm:mb-6">
            Full Information
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">

            <div>
                <p class="text-gray-500 text-sm">Full Name</p>
                <p class="font-semibold text-sm sm:text-base">{{ $user->name }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Employee Code</p>
                <p class="font-semibold text-sm sm:text-base">{{ $user->employee_code }}</p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Email</p>
                <p class="font-semibold text-sm sm:text-base break-all">
                    {{ $user->email }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Role</p>
                <p class="font-semibold text-sm sm:text-base">
                    {{ ucfirst($user->role?->name) }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Join Date</p>
                <p class="font-semibold text-sm sm:text-base">
                    {{ $user->created_at->format('M d, Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Status</p>
                <p class="font-semibold text-sm sm:text-base">
                    {{ ucfirst($user->status) }}
                </p>
            </div>

        </div>

    </div>

</div>

@endsection