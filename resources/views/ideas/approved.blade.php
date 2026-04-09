@extends('layouts.app')

@section('title', 'Approved Ideas')
@section('page-title', 'Approved Ideas')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- ================= SEARCH / FILTER ================= --}}
    <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">

        {{-- Search --}}
        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search ideas..." title="Search ideas..."
            class="app-input">


        <div class="flex gap-3 w-full sm:w-auto">
            {{-- From Date --}}
            <div class="w-full sm:w-auto">
                
                <input type="date"
                    name="from_date"
                    value="{{ request('from_date') }}"
                    class="app-input" title="From">
            </div>

            {{-- To Date --}}
            <div class="w-full sm:w-auto">
               
                <input type="date"
                    name="to_date"
                    value="{{ request('to_date') }}"
                    class="app-input" title="To">
            </div>
        </div>
        {{-- Buttons --}}
        <div class="flex gap-3 w-full sm:w-auto">

            <button class="flex-1 sm:flex-none bg-indigo-600 text-white px-4 py-2 rounded">
                Filter
            </button>

            <a href="{{ route('ideas.approved') }}"
                class="flex-1 sm:flex-none bg-gray-200 px-4 py-2 rounded text-center">
                Reset
            </a>

        </div>

    </form>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                {{-- Header --}}
                <thead class="bg-lime-400 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-3 py-2 sm:px-4 border">#</th>
                        <th class="px-3 py-2 sm:px-4 border">Title</th>
                        <th class="px-3 py-2 sm:px-4 border">User</th>
                        <th class="px-3 py-2 sm:px-4 border">Approved</th>
                        <th class="px-3 py-2 sm:px-4 border">Action</th>
                    </tr>
                </thead>

                {{-- Body --}}
                <tbody class="divide-y">

                    @forelse($ideas as $idea)
                    <tr>

                        {{-- Index --}}
                        <td class="px-3 py-2 sm:px-4 border text-center">
                            {{ $ideas->firstItem() + $loop->index }}
                        </td>

                        {{-- Title --}}
                        <td class="px-3 py-2 sm:px-4 border max-w-[150px] truncate">
                            {{ $idea->title }}
                        </td>

                        {{-- User --}}
                        <td class="px-3 py-2 sm:px-4 border">
                            {{ $idea->user->name }}
                        </td>

                        {{-- Date --}}
                        <td class="px-3 py-2 sm:px-4 border">
                            {{ $idea->updated_at->format('d M Y') }}
                        </td>

                        {{-- Action --}}
                        <td class="px-3 py-2 sm:px-4 border">
                            <a href="{{ route('ideas.show', $idea) }}"
                                class="text-indigo-600">
                                View
                            </a>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="5"
                            class="text-center py-6 text-gray-500">
                            No approved ideas found.
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        <div class="p-4">
            {{ $ideas->links() }}
        </div>

    </div>

</div>

@endsection