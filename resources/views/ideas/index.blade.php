@extends('layouts.app')

@section('title', 'Ideas')
@section('page-title', 'Ideas')

@section('content')

<div class="bg-white rounded shadow overflow-x-auto">

    <table class="min-w-full border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">Title</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Submitted By</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($ideas as $idea)
            <tr class="border-t">
                <td class="px-4 py-3">{{ $idea->title }}</td>
                <td class="px-4 py-3">{{ $idea->user->name }}</td>

                <td class="px-4 py-3">
                    <span class="px-2 py-1 text-xs rounded
                        @if($idea->status === 'approved') bg-green-100 text-green-700
                        @elseif($idea->status === 'rejected') bg-red-100 text-red-700
                        @elseif($idea->status === 'submitted') bg-yellow-100 text-yellow-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ ucfirst($idea->status->value) }}
                    </span>
                </td>

                <td class="px-4 py-3 space-x-2">

                    {{-- Employee: Edit Draft --}}
                    @if(auth()->user()->can('update', $idea))
                    <a href="{{ route('ideas.edit', $idea) }}"
                        class="text-blue-600 hover:underline">
                        Edit
                    </a>
                    @endif

                    {{-- Team Lead / Admin: Review --}}
                    @can('review', $idea)
                    <a href="{{ route('ideas.show', $idea) }}"
                        class="text-indigo-600 hover:underline">
                        Review
                    </a>
                    @endcan

                    {{-- Everyone --}}
                    <a href="{{ route('ideas.show', $idea) }}"
                        class="text-gray-600 hover:underline">
                        View
                    </a>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                    No ideas found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

<div class="mt-4">
    {{ $ideas->links() }}
</div>

@endsection