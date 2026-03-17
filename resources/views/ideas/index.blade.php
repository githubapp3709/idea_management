@extends('layouts.app')

@section('title', 'Ideas')
@section('page-title', 'Ideas')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold"></h1>

        <a href="{{ route('ideas.create') }}"
            class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
            Submit New Idea
        </a>
    </div>

    {{-- STATUS CARDS --}}
    <div class="grid grid-cols-5 gap-6">

        {{-- Total --}}
        <a href="{{ route('ideas.index') }}"
            class="bg-indigo-500 text-white rounded-xl p-6 shadow flex items-center justify-between">
            <div>
                <p class="text-sm">Total</p>
                <h3 class="text-2xl font-semibold">{{ $stats['total'] }}</h3>
            </div>
            <span class="text-3xl">📊</span>
        </a>

        {{-- Draft --}}
        <a href="{{ route('ideas.index', ['status' => 'draft']) }}"
            class="bg-gray-500 text-white rounded-xl p-6 shadow flex items-center justify-between">
            <div>
                <p class="text-sm">Draft</p>
                <h3 class="text-2xl font-semibold">{{ $stats['draft'] }}</h3>
            </div>
            <span class="text-3xl">📝</span>
        </a>

        {{-- Submitted --}}
        <a href="{{ route('ideas.index', ['status' => 'submitted']) }}"
            class="bg-purple-500 text-white rounded-xl p-6 shadow flex items-center justify-between">
            <div>
                <p class="text-sm">Submitted</p>
                <h3 class="text-2xl font-semibold">{{ $stats['submitted'] }}</h3>
            </div>
            <span class="text-3xl">🚀</span>
        </a>

        {{-- Approved --}}
        <a href="{{ route('ideas.index', ['status' => 'approved']) }}"
            class="bg-green-500 text-white rounded-xl p-6 shadow flex items-center justify-between">
            <div>
                <p class="text-sm">Approved</p>
                <h3 class="text-2xl font-semibold">{{ $stats['approved'] }}</h3>
            </div>
            <span class="text-3xl">✅</span>
        </a>

        {{-- Rejected --}}
        <a href="{{ route('ideas.index', ['status' => 'rejected']) }}"
            class="bg-red-500 text-white rounded-xl p-6 shadow flex items-center justify-between">
            <div>
                <p class="text-sm">Rejected</p>
                <h3 class="text-2xl font-semibold">{{ $stats['rejected'] }}</h3>
            </div>
            <span class="text-3xl">❌</span>
        </a>

    </div>


    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="min-w-full text-sm">

            {{-- Header --}}
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Title</th>
                    <th class="px-6 py-3 text-left">Submitted By</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Submitted At</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($ideas as $idea)
                <tr>

                    {{-- Serial Number --}}
                    <td class="px-6 py-4">
                        {{ $ideas->firstItem() + $loop->index }}
                    </td>

                    {{-- Title --}}
                    <td class="px-6 py-4">
                        {{ $idea->title }}
                    </td>

                    {{-- Submitted By --}}
                    <td class="px-6 py-4">
                        {{ $idea->user->name }}
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($idea->status->value === 'approved') bg-green-100 text-green-700
                        @elseif($idea->status->value === 'rejected') bg-red-100 text-red-700
                        @elseif($idea->status->value === 'submitted') bg-purple-100 text-purple-700
                        @else bg-yellow-100 text-yellow-700
                        @endif">
                            {{ ucfirst($idea->status->value) }}
                        </span>
                    </td>

                    {{-- Submitted At --}}
                    <td class="px-6 py-4">
                        {{ $idea->submitted_at 
                        ? $idea->submitted_at->format('d M Y') 
                        : '-' }}
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 flex gap-4">

                        {{-- Review (Team Lead / Admin) --}}
                        @can('review', $idea)
                        @if($idea->status->value === 'submitted')
                        <a href="{{ route('ideas.show', $idea) }}"
                            class="text-indigo-600 hover:underline">
                            Review
                        </a>
                        @endif
                        @endcan

                        {{-- Edit (Only Draft Owner) --}}
                        @if($idea->status->value === 'draft')
                        @can('update', $idea)
                        <a href="{{ route('ideas.edit', $idea) }}"
                            class="text-green-600 hover:underline">
                            Edit
                        </a>
                        @endcan
                        @endif

                        {{-- View --}}
                        <a href="{{ route('ideas.show', $idea) }}"
                            class="text-gray-600 hover:underline">
                            View
                        </a>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6"
                        class="px-6 py-6 text-center text-gray-500">
                        No ideas found.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

        {{-- Pagination --}}
        <div class="p-6">
            {{ $ideas->links() }}
        </div>

    </div>


</div>

@endsection