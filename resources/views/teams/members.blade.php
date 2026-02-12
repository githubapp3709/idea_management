@extends('layouts.app')

@section('title', 'Assign Members')
@section('page-title', 'Assign Members to ' . $team->name)

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

<form method="POST"
      action="{{ route('teams.members.update', $team) }}">
    @csrf

    <div class="mb-4">
        <label class="block text-sm font-medium mb-2">
            Select Members
        </label>

        <div class="grid grid-cols-2 gap-2">

            @foreach($employees as $employee)
                <label class="flex items-center gap-2">
                    <input type="checkbox"
                           name="members[]"
                           value="{{ $employee->id }}"
                           {{ $employee->team_id == $team->id ? 'checked' : '' }}>
                    {{ $employee->name }}
                </label>
            @endforeach

        </div>
    </div>

    <div class="mt-6">
        <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded">
            Save Members
        </button>
    </div>

</form>

</div>

@endsection
