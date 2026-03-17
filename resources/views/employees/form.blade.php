@extends('layouts.app')

@section('title', isset($user) ? 'Edit Employee' : 'Add New Employee')
@section('page-title', isset($user) ? 'Edit Employee' : 'Add New Employee')

@section('content')

<div class="max-w-6xl mx-auto bg-white p-10 rounded-2xl shadow-lg">

    <form method="POST"
        enctype="multipart/form-data"
        action="{{ isset($user)
                ? route('employees.update', $user)
                : route('employees.store') }}">

        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div class="grid grid-cols-2 gap-10">

            {{-- LEFT SIDE --}}
            <div class="space-y-6">

                <div>
                    <label class="font-semibold">Full Name *</label>
                    <input type="text"
                        name="name"
                        value="{{ old('name', $user->name ?? '') }}"
                        class="w-full border px-4 py-3 rounded-lg">
                    @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label>Employee Code</label>
                    <input type="text"
                        name="employee_code"
                        value="{{ old('employee_code', $user->employee_code ?? '') }}"
                        class="w-full border px-4 py-3 rounded-lg">
                    @error('employee_code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label>Email *</label>
                    <input type="email"
                        name="email"
                        value="{{ old('email', $user->email ?? '') }}"
                        class="w-full border px-4 py-3 rounded-lg">
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>



                <div>
                    <label>Password (optional)</label>
                    <input type="password"
                        name="password"
                        placeholder="Leave empty to auto-generate"
                        class="w-full border px-4 py-3 rounded-lg">
                </div>

                <div>
                    <label class="font-semibold">Team</label>
                    <select name="team_id"
                        class="w-full border px-4 py-3 rounded-lg">

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


                <div>
                    <label>Status *</label>
                    <select name="status"
                        class="w-full border px-4 py-3 rounded-lg">
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
                <div class="border-2 border-dashed rounded-xl p-6 bg-gray-50">
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 rounded-full overflow-hidden shadow">
                            <img src="{{ isset($user) ? $user->profile_image_url : asset('images/default-user.jpg') }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-semibold text-lg">Upload Profile Image</p>
                            <p class="text-sm text-gray-500">JPG, PNG, GIF up to 5MB</p>
                            <input type="file"
                                name="profile_image"
                                class="mt-3 text-sm">
                                @error('profile_image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 text-center">
            <button class="px-10 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow-md hover:scale-105 transition">
                {{ isset($user) ? 'Update Employee' : 'Add Employee' }}
            </button>
        </div>

    </form>

</div>

@endsection