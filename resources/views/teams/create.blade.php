@extends('layouts.app')

@section('title', 'Create Team')
@section('page-title', 'Create Team')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

<form method="POST" action="{{ route('teams.store') }}">
    @csrf

    <div class="mb-4">
        <label class="block text-sm font-medium">Team Name</label>
        <input type="text" name="name"
               class="w-full border rounded px-3 py-2"
               required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium">Team Lead</label>
        <select name="leader_id"
                class="w-full border rounded px-3 py-2">
            <option value="">Select Leader</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded">
        Save
    </button>

</form>

</div>

@endsection
