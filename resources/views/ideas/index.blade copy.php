@extends('layouts.app')

@section('title', 'Ideas')
@section('page-title', 'Ideas')

@section('content')

{{-- ✅ OUTER WRAPPER (VERY IMPORTANT) --}}
<div class="w-full overflow-x-hidden">

    {{-- ✅ MAIN CONTAINER --}}
    <div class="max-w-7xl mx-auto px-0 sm:px-6 lg:px-0 space-y-6">

        <form method="GET"
            action="{{ route('ideas.index') }}"
            class="flex gap-3 w-full">

            {{-- Search --}}
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search title, description, user..."
                class="app-input border px-3 py-2 rounded w-64">

            {{-- Status --}}
            <select name="status" class="app-input border px-3 py-2 rounded">
                <option value="">All Status</option>
                @foreach(['draft','submitted','approved','rejected'] as $status)
                <option value="{{ $status }}"
                    {{ request('status') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
                @endforeach
            </select>

            {{-- From Date --}}
            <input type="date"
                name="from_date"
                value="{{ request('from_date') }}"
                class="app-input border px-3 py-2 rounded">

            {{-- To Date --}}
            <input type="date"
                name="to_date"
                value="{{ request('to_date') }}"
                class="app-input border px-3 py-2 rounded">

            {{-- Buttons --}}
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                Filter
            </button>

            <a href="{{ route('ideas.index') }}"
                class="bg-gray-200 px-4 py-2 rounded">
                Reset
            </a>

        </form>

        {{-- ================= STATUS CARDS ================= --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4">

            {{-- Card --}}
            <a href="{{ route('ideas.index') }}"
                class="w-full bg-indigo-500 text-white rounded-xl p-4 sm:p-6 shadow flex items-center justify-between">
                <div>
                    <p class="text-sm">Total</p>
                    <h3 class="text-2xl font-semibold">{{ $stats['total'] }}</h3>
                </div>
                <div class="p-2 bg-indigo-200 rounded shrink-0">
                    <img src="{{ asset('images/total idea.png') }}" alt="">
                </div>

            </a>

            <a href="{{ route('ideas.index', ['status' => 'draft']) }}"
                class="w-full bg-gray-500 text-white rounded-xl p-4 sm:p-6 shadow flex items-center justify-between">
                <div>
                    <p class="text-sm">Draft</p>
                    <h3 class="text-2xl font-semibold">{{ $stats['draft'] }}</h3>
                </div>

                <div class="p-2 bg-gray-200 rounded shrink-0">
                    <img src="{{ asset('images/draft idea.png') }}" alt="">
                </div>

            </a>

            <a href="{{ route('ideas.index', ['status' => 'submitted']) }}"
                class="w-full bg-purple-500 text-white rounded-xl p-4 sm:p-6 shadow flex items-center justify-between">
                <div>
                    <p class="text-sm">Submitted</p>
                    <h3 class="text-2xl font-semibold">{{ $stats['submitted'] }}</h3>
                </div>
                <div class="p-2 bg-purple-200 rounded shrink-0">
                    <img src="{{ asset('images/submitted.png') }}" alt="">
                </div>
            </a>

            <a href="{{ route('ideas.index', ['status' => 'approved']) }}"
                class="w-full bg-green-500 text-white rounded-xl p-4 sm:p-6 shadow flex items-center justify-between">
                <div>
                    <p class="text-sm">Approved</p>
                    <h3 class="text-2xl font-semibold">{{ $stats['approved'] }}</h3>
                </div>
                <div class="p-2 bg-green-200 rounded shrink-0">
                    <img src="{{ asset('images/approved.png') }}" alt="">
                </div>

            </a>

            <a href="{{ route('ideas.index', ['status' => 'rejected']) }}"
                class="w-full bg-red-500 text-white rounded-xl p-4 sm:p-6 shadow flex items-center justify-between">
                <div>
                    <p class="text-sm">Rejected</p>
                    <h3 class="text-2xl font-semibold">{{ $stats['rejected'] }}</h3>
                </div>
                <div class="p-2 bg-red-200 rounded shrink-0">
                    <img src="{{ asset('images/rejected.png') }}" alt="">
                </div>
            </a>

        </div>

        {{-- ================= HEADER ================= --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            {{-- Button --}}
            <a href="{{ route('ideas.create') }}"
                class="w-full lg:w-auto text-center px-4 py-2 bg-green-600 text-white rounded-lg">
                Submit New Idea
            </a>

            <!-- {{-- Search --}}
            <form method="GET"
                action="{{ route('ideas.index') }}"
                class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search ideas..."
                    class="border px-3 py-2 rounded w-full sm:w-64">

                @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <div class="flex gap-3">
                    <button class="flex-1 sm:flex-none bg-indigo-600 text-white px-4 py-2 rounded">
                        Search
                    </button>

                    <a href="{{ route('ideas.index') }}"
                        class="flex-1 sm:flex-none bg-gray-200 px-4 py-2 rounded text-center">
                        Reset
                    </a>
                </div>
            </form> -->

        </div>

        {{-- ================= TABLE ================= --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    {{-- Header --}}
                    <thead class="bg-gray-100 text-gray-600 text-xs uppercase">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 border">#</th>
                            <th class="px-3 py-2 sm:px-4 border">Title</th>
                            <th class="px-3 py-2 sm:px-4 border">Submitted By</th>
                            <th class="px-3 py-2 sm:px-4 border">Status</th>
                            <th class="px-3 py-2 sm:px-4 border">Date</th>
                            <th class="px-3 py-2 sm:px-4 border">Actions</th>
                        </tr>
                    </thead>

                    {{-- Body --}}
                    <tbody class="divide-y">

                        @forelse($ideas as $idea)
                        <tr>

                            <td class="px-3 py-2 sm:px-4 border">
                                {{ $ideas->firstItem() + $loop->index }}
                            </td>

                            <td class="px-3 py-2 sm:px-4 border max-w-[140px] truncate">
                                {{ $idea->title }}
                            </td>

                            <td class="px-3 py-2 sm:px-4 border">
                                {{ $idea->user->name }}
                            </td>

                            <td class="px-3 py-2 sm:px-4 border">
                                <span class="text-xs px-2 py-1 rounded
                                    @if($idea->status->value === 'approved') bg-green-100 text-green-700
                                    @elseif($idea->status->value === 'rejected') bg-red-100 text-red-700
                                    @elseif($idea->status->value === 'submitted') bg-purple-100 text-purple-700
                                    @else bg-yellow-100 text-yellow-700
                                    @endif">
                                    {{ ucfirst($idea->status->value) }}
                                </span>
                            </td>

                            <td class="px-3 py-2 sm:px-4 border">
                                {{ $idea->submitted_at ? $idea->submitted_at->format('d M Y') : '-' }}
                            </td>

                            <td class="px-3 py-2 sm:px-4 border">
                                <div class="flex flex-wrap gap-2 text-sm">

                                    <a href="{{ route('ideas.show', $idea) }}"
                                        class="text-gray-600">View</a>

                                    @can('update', $idea)
                                    <a href="{{ route('ideas.edit', $idea) }}"
                                        class="text-green-600">Edit</a>
                                    @endcan

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">
                                No ideas found.
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
</div>

@endsection