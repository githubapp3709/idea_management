@extends('layouts.app')

@section('title', 'View Idea')
@section('page-title', 'Idea Details')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-6 lg:p-8">

        <div class="flex flex-col sm:flex-row sm:justify-between gap-6">

            {{-- LEFT --}}
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">

                {{-- Avatar --}}
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gray-200 flex items-center justify-center text-xl font-bold overflow-hidden shrink-0">

                    @if($idea->user->profile_image ?? false)
                    <img src="{{ asset('storage/'.$idea->user->profile_image) }}"
                        class="w-full h-full object-cover">
                    @else
                    {{ strtoupper(substr($idea->user->name,0,1)) }}
                    @endif
                </div>

                {{-- Info --}}
                <div>
                    <h1 class="text-lg sm:text-xl lg:text-2xl font-semibold">
                        {{ $idea->title }}
                    </h1>

                    <div class="mt-2 space-y-1 text-xs sm:text-sm text-gray-600">
                        <div><strong>{{ $idea->user->name }}</strong></div>
                        <div class="break-all">{{ $idea->user->email }}</div>
                        <div>{{ $idea->user->team?->name ?? 'No Team Assigned' }}</div>
                        <div>Submitted {{ $idea->created_at->format('M d, Y') }}</div>
                    </div>

                    {{-- Tags --}}
                    <div class="flex flex-wrap gap-2 mt-3">

                        <span class="px-2 py-1 rounded text-xs font-semibold
                            {{ $idea->impact_level === 'high' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $idea->impact_level === 'medium' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $idea->impact_level === 'low' ? 'bg-green-100 text-green-700' : '' }}">
                            {{ ucfirst($idea->impact_level) }}
                        </span>

                        <span class="px-2 py-1 rounded bg-indigo-100 text-indigo-700 text-xs">
                            {{ $idea->category }}
                        </span>

                    </div>
                </div>

            </div>

            {{-- STATUS --}}
            <div class="self-start sm:self-auto">
                <span class="px-3 py-1 sm:px-4 sm:py-2 rounded text-xs sm:text-sm font-semibold
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

    {{-- ================= MAIN GRID ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

        {{-- LEFT --}}
        <div class="lg:col-span-2 space-y-6">

            @if($idea->review_remark)
            <div class="bg-yellow-500 text-white rounded-2xl shadow p-4 sm:p-6">
                <h3 class="font-semibold mb-2">Feedback</h3>
                <p class="text-white">{{ $idea->review_remark }}</p>
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
                <h3 class="font-semibold mb-2">Idea Description</h3>
                <p class="text-gray-700">{{ $idea->description }}</p>
            </div>

            @if($idea->swot)
            <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
                <h3 class="font-semibold mb-2">SWOT Analysis</h3>
                <p>{{ $idea->swot }}</p>
            </div>
            @endif

            @if($idea->expected_benefit)
            <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
                <h3 class="font-semibold mb-2">Expected Benefits</h3>
                <p>{{ $idea->expected_benefit }}</p>
            </div>
            @endif

            {{-- Attachments --}}
            <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
                <h3 class="font-semibold mb-4">Attachments</h3>

                @if($idea->attachments->count())

                {{-- Images --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mb-4">
                    @foreach($idea->attachments->where('file_type','image') as $file)
                    <img src="{{ asset('storage/'.$file->file_path) }}"
                        class="w-full h-24 object-cover rounded">
                    @endforeach
                </div>

                {{-- Videos --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4 text-sm">
                    @foreach($idea->attachments->where('file_type','video') as $file)
                    <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">
                        🎥 View Video
                    </a>
                    @endforeach
                </div>

                {{-- Documents --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                    @foreach($idea->attachments->where('file_type','document') as $file)
                    <a href="{{ asset('storage/'.$file->file_path) }}"
                        target="_blank"
                        class="text-indigo-600 underline truncate">
                        📄 {{ basename($file->file_path) }}
                    </a>
                    @endforeach
                </div>

                @else
                <p class="text-gray-500">No attachments available.</p>
                @endif
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            {{-- Timeline --}}
            <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
                <h3 class="font-semibold mb-4">Review Status</h3>

                <div class="flex flex-wrap justify-between gap-3 text-xs sm:text-sm text-center">

                    @foreach(['Submitted','Review','Feedback','Final'] as $i => $step)
                    <div class="flex-1 min-w-[60px]">
                        <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center text-white
                            {{ ['bg-purple-500','bg-blue-500','bg-yellow-500','bg-green-500'][$i] }}">
                            {{ $i+1 }}
                        </div>
                        <p class="mt-1">{{ $step }}</p>
                    </div>
                    @endforeach

                </div>
            </div>

            {{-- Submit Button --}}
            @can('submit', $idea)
            <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
                <form method="POST"
                    action="{{ route('ideas.submit', $idea) }}"
                    onsubmit="return confirm('Submit this idea for review?');">
                    @csrf

                    <button type="submit"
                        class="w-full py-2 bg-indigo-600 text-white rounded-lg">
                        Submit for Review
                    </button>
                </form>
            </div>
            @endcan

        </div>

    </div>

    {{-- ================= REVIEW ================= --}}
    @can('review', $idea)
    @if($idea->status->value === 'submitted')

    <div class="bg-white p-4 sm:p-6 rounded-2xl shadow border">
        <h3 class="font-semibold mb-4">Review Decision</h3>

        <form method="POST" action="{{ route('ideas.review', $idea) }}">
            @csrf
            <div class="flex justify-center pb-4 gap-4">
                <div class="w-full">
                    <label>Category *</label>
                    <select name="category"
                        class="w-full border px-4 py-3 rounded-lg">
                        <option value="">Select Category</option>
                        <option value="HR" {{ $idea->category == 'HR' ? 'selected' : '' }}>HR</option>
                        <option value="Tech" {{ $idea->category == 'Tech' ? 'selected' : '' }}>Tech</option>
                        <option value="Process" {{ $idea->category == 'Process' ? 'selected' : '' }}>Process</option>
                        <option value="Sales" {{ $idea->category == 'Sales' ? 'selected' : '' }}>Sales</option>
                    </select>
                    @error('category')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full">
                    <label>Impact Level *</label>
                    <div class="flex gap-4 mt-2">

                        <label>
                            <input type="radio"
                                name="impact_level"
                                value="low"
                                {{ $idea->impact_level == 'low' ? 'checked' : '' }}>
                            Low
                        </label>

                        <label>
                            <input type="radio"
                                name="impact_level"
                                value="medium"
                                {{ $idea->impact_level == 'medium' ? 'checked' : '' }}>
                            Medium
                        </label>

                        <label>
                            <input type="radio"
                                name="impact_level"
                                value="high"
                                {{ $idea->impact_level == 'high' ? 'checked' : '' }}>
                            High
                        </label>

                    </div>
                    @error('impact_level')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>                
            </div>

            <textarea name="remark"
                    rows="3"
                    class="w-full border rounded px-3 py-2 mb-4"
                    placeholder="Enter remark..."></textarea>

            <div class="flex flex-col sm:flex-row gap-3">
                <button name="action" value="approve"
                    class="w-full sm:w-auto bg-green-600 text-white px-4 py-2 rounded">
                    Approve
                </button>

                <button name="action" value="reject"
                    class="w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded">
                    Reject
                </button>

                <button name="action" value="send_back"
                    class="w-full sm:w-auto bg-yellow-500 text-white px-4 py-2 rounded">
                    Send Back
                </button>
            </div>


        </form>
    </div>

    @endif
    @endcan

</div>

@endsection