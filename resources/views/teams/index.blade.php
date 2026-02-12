@extends('layouts.app')

@section('title', 'Teams')
@section('page-title', 'Teams')

@section('content')

<div class="mb-4">
    <a href="{{ route('teams.create') }}"
        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
        + Create Team
    </a>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left text-sm">Name</th>
                <th class="px-4 py-3 text-left text-sm">Leader</th>
                <th class="px-4 py-3 text-left text-sm">Members</th>
                <th class="px-4 py-3 text-left text-sm">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($teams as $team)
            <tr class="border-t">
                <td class="px-4 py-3">{{ $team->name }}</td>
                <td class="px-4 py-3">
                    {{ $team->leader?->name ?? 'Not Assigned' }}
                </td>
                <td class="px-4 py-3">
                    {{ $team->members->count() }}
                </td>
                <td class="px-4 py-3">
                    <a href="{{ route('teams.edit', $team) }}"
                        class="text-indigo-600 hover:underline">
                        Edit
                    </a>
                    <a href="{{ route('teams.members', $team) }}"
                        class="text-green-600 hover:underline">
                        Members
                    </a>
                    <form method="POST"
                        action="{{ route('teams.destroy', $team) }}"
                        onsubmit="return confirm('Are you sure you want to delete this team?')"
                        class="inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="text-red-600 hover:underline ml-2">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $teams->links() }}
</div>

@endsection