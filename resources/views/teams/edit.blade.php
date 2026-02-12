@extends('layouts.app')

@section('title', 'Edit Team')
@section('page-title', 'Edit Team')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

<form method="POST" action="{{ route('teams.update', $team) }}">
    @csrf
    @method('PUT')

    {{-- Team Name --}}
    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">
            Team Name
        </label>

        <input type="text"
               name="name"
               value="{{ old('name', $team->name) }}"
               class="w-full border rounded px-3 py-2"
               required>

        @error('name')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    {{-- Team Lead --}}
    <div class="mb-6">
        <label class="block text-sm font-medium mb-1">
            Team Lead
        </label>

        <select name="leader_id"
                class="w-full border rounded px-3 py-2">

            <option value="">Select Leader</option>

            @foreach($users as $user)
                <option value="{{ $user->id }}"
                    {{ old('leader_id', $team->leader_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach

        </select>

        @error('leader_id')
            <p class="text-red-600 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div class="flex justify-between">

        <a href="{{ route('teams.index') }}"
           class="px-4 py-2 bg-gray-200 rounded">
            Back
        </a>

        <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Update Team
        </button>

    </div>

</form>

</div>

@endsection
