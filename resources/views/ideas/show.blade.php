@extends('layouts.app')

@section('title', 'View Idea')
@section('page-title', 'Idea Details')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- ================= HEADER CARD ================= --}}
    {{-- ================= HEADER CARD ================= --}}
<div class="bg-white rounded-2xl shadow p-8">

    <div class="flex justify-between items-start">

        {{-- LEFT SIDE --}}
        <div class="flex items-center gap-6">

            {{-- USER PHOTO --}}
            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-2xl font-bold overflow-hidden shadow">

                @if($idea->user->profile_image ?? false)
                    <img src="{{ asset('storage/'.$idea->user->profile_image) }}"
                         class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr($idea->user->name,0,1)) }}
                @endif

            </div>

            {{-- USER INFO --}}
            <div>
                <h1 class="text-2xl font-semibold">
                    {{ $idea->title }}
                </h1>

                <div class="mt-2 space-y-1 text-sm text-gray-600">

                    <div>
                        <strong>{{ $idea->user->name }}</strong>
                    </div>

                    <div>
                        {{ $idea->user->email }}
                    </div>

                    <div>
                        {{ $idea->user->team?->name ?? 'No Team Assigned' }}
                    </div>

                    <div>
                        Submitted {{ $idea->created_at->format('M d, Y') }}
                    </div>

                </div>

                {{-- Tags --}}
                <div class="flex items-center gap-3 mt-4">

                    {{-- Impact --}}
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $idea->impact_level === 'high' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $idea->impact_level === 'medium' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $idea->impact_level === 'low' ? 'bg-green-100 text-green-700' : '' }}">
                        {{ ucfirst($idea->impact_level) }}
                    </span>

                    {{-- Category --}}
                    <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs">
                        {{ $idea->category }}
                    </span>

                </div>
            </div>

        </div>

        {{-- RIGHT SIDE STATUS BADGE --}}
        <div>
            <span class="px-4 py-2 rounded-lg text-sm font-semibold
                @if($idea->status->value === 'approved') bg-green-100 text-green-700
                @elseif($idea->status->value === 'rejected') bg-red-100 text-red-700
                @elseif($idea->status->value === 'submitted') bg-purple-100 text-purple-700
                @elseif($idea->status->value === 'draft') bg-gray-100 text-gray-700
                @else bg-blue-100 text-blue-700
                @endif">
                {{ ucfirst($idea->status->value) }}
            </span>
        </div>

    </div>
</div>


    {{-- ================= MAIN CONTENT ================= --}}
    <div class="grid grid-cols-3 gap-8">

        {{-- LEFT SIDE --}}
        <div class="col-span-2 space-y-6">

            {{-- Idea Description --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold mb-3">Idea Description</h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ $idea->description }}
                </p>
            </div>

            {{-- Expected Benefits (Optional if you have column) --}}
            @if($idea->expected_benefit)
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold mb-3">Expected Benefits</h3>
                <p class="text-gray-700">
                    {{ $idea->expected_benefit }}
                </p>
            </div>
            @endif

            {{-- Attachments --}}
            @if($idea->attachments->count())
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Attachments</h3>

                {{-- Images --}}
                <div class="grid grid-cols-4 gap-4 mb-4">
                    @foreach($idea->attachments->where('file_type','image') as $image)
                        <img src="{{ asset('storage/'.$image->file_path) }}"
                             class="w-full h-28 object-cover rounded-lg shadow">
                    @endforeach
                </div>

                {{-- Videos --}}
                @foreach($idea->attachments->where('file_type','video') as $video)
                    <div class="border rounded-lg p-4 flex justify-between items-center">
                        <span>🎥 {{ basename($video->file_path) }}</span>
                        <a href="{{ asset('storage/'.$video->file_path) }}"
                           target="_blank"
                           class="text-indigo-600 text-sm hover:underline">
                           View
                        </a>
                    </div>
                @endforeach

            </div>
            @endif

        </div>

        {{-- RIGHT SIDE --}}
        <div class="space-y-6">

            {{-- Review Status Timeline --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-semibold mb-4">Review Status</h3>

                <div class="flex justify-between text-xs text-center">

                    <div>
                        <div class="w-8 h-8 mx-auto rounded-full bg-purple-500 text-white flex items-center justify-center">1</div>
                        <p class="mt-2">Submitted</p>
                    </div>

                    <div>
                        <div class="w-8 h-8 mx-auto rounded-full bg-blue-500 text-white flex items-center justify-center">2</div>
                        <p class="mt-2">Under Review</p>
                    </div>

                    <div>
                        <div class="w-8 h-8 mx-auto rounded-full bg-yellow-500 text-white flex items-center justify-center">3</div>
                        <p class="mt-2">Feedback</p>
                    </div>

                    <div>
                        <div class="w-8 h-8 mx-auto rounded-full bg-green-500 text-white flex items-center justify-center">4</div>
                        <p class="mt-2">Final</p>
                    </div>

                </div>
            </div>

            {{-- Submit Button (Draft Only) --}}
            @can('submit', $idea)
            <div class="bg-white rounded-2xl shadow p-6">
                <form method="POST"
                      action="{{ route('ideas.submit', $idea) }}"
                      onsubmit="return confirm('Submit this idea for review?');">
                    @csrf

                    <button type="submit"
                            class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Submit for Review
                    </button>
                </form>
            </div>
            @endcan

        </div>
    </div>

    {{-- ================= REVIEW SECTION ================= --}}
    @can('review', $idea)

        @if($idea->status->value === 'submitted')

        <div class="bg-white p-6 rounded-2xl shadow border">
            <h3 class="text-lg font-semibold mb-4">Review Decision</h3>

            <form method="POST" action="{{ route('ideas.review', $idea) }}">
                @csrf

                <div class="mb-4">
                    <textarea name="remark"
                              rows="3"
                              class="w-full border rounded px-3 py-2"
                              placeholder="Enter remark (required for reject or send back)"></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            name="action"
                            value="approve"
                            class="px-4 py-2 bg-green-600 text-white rounded">
                        Approve
                    </button>

                    <button type="submit"
                            name="action"
                            value="reject"
                            class="px-4 py-2 bg-red-600 text-white rounded">
                        Reject
                    </button>

                    <button type="submit"
                            name="action"
                            value="send_back"
                            class="px-4 py-2 bg-yellow-500 text-white rounded">
                        Send Back
                    </button>
                </div>
            </form>
        </div>

        @endif

    @endcan

</div>

@endsection
