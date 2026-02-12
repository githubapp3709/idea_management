@extends('layouts.app')

@section('title', 'View Idea')
@section('page-title', 'Idea Details')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Idea Info --}}
    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-xl font-semibold mb-2">
            {{ $idea->title }}
        </h2>

        <p class="text-gray-600 mb-4">
            {{ $idea->description }}
        </p>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><strong>Category:</strong> {{ $idea->category }}</div>
            <div><strong>Impact:</strong> {{ ucfirst($idea->impact_level) }}</div>
            <div><strong>Status:</strong> {{ ucfirst($idea->status->value) }}</div>
            <div><strong>Submitted by:</strong> {{ $idea->user->name }}</div>

        </div>
    </div>

    {{-- SUBMIT BUTTON (ONLY FOR OWNER + DRAFT) --}}
    @can('submit', $idea)
    <div class="bg-white p-4 rounded shadow">
        <form method="POST"
            action="{{ route('ideas.submit', $idea) }}"
            onsubmit="return confirm('Submit this idea for review? You will not be able to edit it after submission.')">
            @csrf

            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Submit for Review
            </button>
        </form>
    </div>
    @endcan

    {{-- REVIEW SECTION --}}
    @can('review', $idea)

    @if($idea->status === \App\Enums\IdeaStatus::Submitted)

    <div class="bg-white p-6 rounded shadow border border-gray-200">
        <h3 class="text-lg font-semibold mb-4">Review Decision</h3>

        {{-- Validation Errors --}}
        @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('ideas.review', $idea) }}">
            @csrf

            {{-- Remark --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">
                    Remark <span class="text-red-500">*</span>
                </label>
                <textarea name="remark"
                    rows="3"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                    placeholder="Required for reject or send back">{{ old('remark') }}</textarea>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3">

                {{-- Approve --}}
                <button type="submit"
                    name="action"
                    value="approve"
                    onclick="return confirm('Approve this idea?')"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Approve
                </button>

                {{-- Reject --}}
                <button type="submit"
                    name="action"
                    value="reject"
                    onclick="return confirm('Reject this idea? This cannot be undone.')"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Reject
                </button>

                {{-- Send Back --}}
                <button type="submit"
                    name="action"
                    value="send_back"
                    onclick="return confirm('Send this idea back for revision?')"
                    class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Send Back
                </button>

            </div>
        </form>
    </div>

    @else
    <div class="bg-gray-100 p-4 rounded text-sm text-gray-600">
        This idea is already
        <strong>{{ ucfirst($idea->status->value) }}</strong>.
    </div>
    @endif

    @endcan



</div>

@endsection