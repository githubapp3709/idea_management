@extends('layouts.app')

@section('title', isset($user) ? 'Edit Employee' : 'Add New Employee')
@section('page-title', isset($user) ? 'Edit Employee' : 'Add New Employee')

@section('content')

<div class="max-w-6xl mx-auto bg-white p-4 sm:p-6 lg:p-10 rounded-2xl shadow-lg">

    <form method="POST"
        enctype="multipart/form-data"
        action="{{ isset($user)
                ? route('employees.update', $user)
                : route('employees.store') }}">

        @csrf
        @if(isset($user)) @method('PUT') @endif

        {{-- ================= GRID ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">

            {{-- LEFT SIDE --}}
            <div class="space-y-5 sm:space-y-6">

                {{-- Name --}}
                <div>
                    <label class="font-semibold">Full Name *</label>
                    <input type="text"
                        name="name"
                        value="{{ old('name', $user->name ?? '') }}"
                        class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">
                    @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Employee Code --}}
                <div class="py-2">
                    <label class="font-semibold">Employee Code</label>
                    <input type="text"
                        name="employee_code"
                        value="{{ old('employee_code', $user->employee_code ?? '') }}"
                        class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">
                    @error('employee_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="py-2">
                    <label class="font-semibold">Email *</label>
                    <input type="email"
                        name="email"
                        value="{{ old('email', $user->email ?? '') }}"
                        class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="py-2">
                    <label class="font-semibold">Password (optional)</label>
                    <input type="password"
                        name="password"
                        placeholder="Leave empty to auto-generate"
                        class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">
                </div>

                {{-- Team --}}
                <div class="py-2">
                    <label class="font-semibold">Team</label>
                    <select name="team_id"
                        class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">
                        <option value="">Select Team</option>

                        @foreach($teams as $team)
                        <option value="{{ $team->id }}"
                            {{ old('team_id', $user->team_id ?? '') == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                        </option>
                        @endforeach
                    </select>

                    @error('team_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="py-2">
                    <label class="font-semibold">Status *</label>
                    <select name="status"
                        class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">
                        <option value="active"
                            {{ old('status', $user->status ?? '') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="inactive"
                            {{ old('status', $user->status ?? '') == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- RIGHT SIDE --}}
            <div>

                <div class="border-2 border-dashed rounded-xl p-4 sm:p-6 bg-gray-50">

                    <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6 text-center sm:text-left">

                        {{-- Image --}}
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden shadow shrink-0">
                            <img src="{{ isset($user) ? $user->profile_image_url : asset('images/default-user.jpg') }}"
                                class="w-full h-full object-cover">
                        </div>

                        {{-- Upload --}}
                        <div>
                            <p class="font-semibold text-base sm:text-lg">
                                Upload Profile Image
                            </p>
                            <p class="text-xs sm:text-sm text-gray-500">
                                JPG, PNG, GIF up to 5MB
                            </p>

                            <input type="file"
                                name="profile_image"
                                class="mt-2 text-sm w-full">

                            @error('profile_image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="mt-6 sm:mt-10 flex justify-center">
            <button
                class="w-full sm:w-auto px-6 sm:px-10 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow-md hover:scale-105 transition">
                {{ isset($user) ? 'Update Employee' : 'Add Employee' }}
            </button>
        </div>

    </form>

</div>

@endsection