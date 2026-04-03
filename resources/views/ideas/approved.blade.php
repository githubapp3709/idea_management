@extends('layouts.app')

@section('title', 'Approved Ideas')
@section('page-title', 'Approved Ideas')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- SEARCH --}}
    <form method="GET" class="mb-6 flex flex-wrap gap-3 items-end">

    {{-- Search --}}
    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Search ideas..."
           class="border px-4 py-2 rounded w-64">

    {{-- From Date --}}
    <div>
        <label class="text-xs text-gray-500">From</label>
        <input type="date"
               name="from_date"
               value="{{ request('from_date') }}"
               class="border px-3 py-2 rounded">
    </div>

    {{-- To Date --}}
    <div>
        <label class="text-xs text-gray-500">To</label>
        <input type="date"
               name="to_date"
               value="{{ request('to_date') }}"
               class="border px-3 py-2 rounded">
    </div>

    {{-- Buttons --}}
    <button class="bg-indigo-600 text-white px-4 py-2 rounded">
        Filter
    </button>

    <a href="{{ route('ideas.approved') }}"
       class="bg-gray-200 px-4 py-2 rounded">
        Reset
    </a>

</form>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="min-w-full text-sm">

            <thead class="bg-lime-400 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left border border-gray-300">#</th>
                    <th class="px-6 py-3 text-left border border-gray-300">Title</th>
                    <th class="px-6 py-3 text-left border border-gray-300">User</th>
                    <th class="px-6 py-3 text-left border border-gray-300">Approved At</th>
                    <th class="px-6 py-3 text-left border border-gray-300">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($ideas as $idea)
                <tr>

                    <td class="px-6 py-4 border border-gray-300">
                        {{ $ideas->firstItem() + $loop->index }}
                    </td>

                    <td class="px-6 py-4 border border-gray-300">
                        {{ $idea->title }}
                    </td>

                    <td class="px-6 py-4 border border-gray-300">
                        {{ $idea->user->name }}
                    </td>

                    <td class="px-6 py-4 border border-gray-300">
                        {{ $idea->updated_at->format('d M Y') }}
                    </td>

                    <td class="px-6 py-4 border border-gray-300">
                        <a href="{{ route('ideas.show', $idea) }}"
                           class="text-indigo-600 hover:underline">
                            View
                        </a>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">
                        No approved ideas found.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

        <div class="p-4">
            {{ $ideas->links() }}
        </div>

    </div>

</div>

@endsection