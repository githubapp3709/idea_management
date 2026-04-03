@extends('layouts.app')

@section('title', 'Submit Idea')
@section('page-title', 'Submit New Idea')

@section('content')

@php use Illuminate\Support\Str; @endphp

<!-- 
@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <strong class="font-bold">Whoops!</strong>
    <span class="block">There were some problems with your input.</span>

    <ul class="mt-2 list-disc list-inside text-sm">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif -->




<div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow">

    <form method="POST"
        action="{{ route('ideas.store') }}"
        enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-3 gap-8">

            {{-- LEFT SECTION --}}
            <div class="col-span-2 space-y-6">

                {{-- Title --}}
                <div>
                    <label class="font-semibold">Title <span class="text-red-500">*</span></label>
                    <input type="text"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full border px-4 py-3 rounded-lg">
                    @error('title')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="font-semibold">Description <span class="text-red-500">*</span></label>
                    <textarea name="description"
                        rows="5"
                        class="w-full border px-4 py-3 rounded-lg">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SWOT --}}
                <div>
                    <label class="font-semibold">SWOT Analysis (Optional)</label>

                    <textarea name="swot"
                        rows="4"
                        placeholder="Strengths, Weaknesses, Opportunities, Threats..."
                        class="w-full border px-4 py-3 rounded-lg">{{ old('swot') }}</textarea>
                    @error('swot')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category & Impact --}}
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label>Category <span class="text-red-500">*</span></label>
                        <select name="category" class="w-full border px-4 py-3 rounded-lg">
                            <option value="">Select Category</option>

                            <option value="HR" {{ old('category', $idea->category ?? '') == 'HR' ? 'selected' : '' }}>HR</option>

                            <option value="Tech" {{ old('category', $idea->category ?? '') == 'Tech' ? 'selected' : '' }}>Tech</option>

                            <option value="Process" {{ old('category', $idea->category ?? '') == 'Process' ? 'selected' : '' }}>Process</option>

                            <option value="Sales" {{ old('category', $idea->category ?? '') == 'Sales' ? 'selected' : '' }}>Sales</option>
                        </select>

                        @error('category')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label>Impact Level <span class="text-red-500">*</span></label>
                        <div class="flex gap-4 mt-2">

                            <label>
                                <input type="radio" name="impact_level" value="low"
                                    {{ old('impact_level', $idea->impact_level ?? '') == 'low' ? 'checked' : '' }}>
                                Low
                            </label>

                            <label>
                                <input type="radio" name="impact_level" value="medium"
                                    {{ old('impact_level', $idea->impact_level ?? '') == 'medium' ? 'checked' : '' }}>
                                Medium
                            </label>

                            <label>
                                <input type="radio" name="impact_level" value="high"
                                    {{ old('impact_level', $idea->impact_level ?? '') == 'high' ? 'checked' : '' }}>
                                High
                            </label>

                        </div>

                        @error('impact_level')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>


                {{-- Attachments --}}
                <div class="border-2 border-dashed rounded-xl p-6 text-center">
                    <p class="font-semibold mb-2">
                        Upload Attachments (Max 5)
                    </p>

                    <p class="text-sm text-gray-500 mb-2">
                        Supported: Images, Videos, Documents (PDF, DOC, etc.)
                    </p>

                    <input type="file"
                        name="attachments[]"
                        multiple
                        class="w-full">

                    @error('attachments.*')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="space-y-6">

                <div class="bg-yellow-50 p-6 rounded-xl shadow-sm">
                    <h3 class="font-semibold mb-3">Idea Guidelines</h3>
                    <ul class="text-sm space-y-2 text-gray-600">
                        <li>• Be clear and specific</li>
                        <li>• Add images/videos for clarity</li>
                        <li>• Mention expected benefits</li>
                        <li>• Avoid sensitive data</li>
                    </ul>
                </div>



                {{-- Review Process --}}
                <div class="bg-white p-6 rounded-xl shadow-sm">

                    <h3 class="font-semibold mb-4 flex items-center gap-2">
                        🔄 Review Process
                    </h3>

                    <div class="flex items-center justify-between text-sm">

                        <div class="text-center">
                            <div class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center mx-auto">1</div>
                            <p class="mt-2 text-xs">Submitted</p>
                        </div>

                        <span class="text-gray-400">→</span>

                        <div class="text-center">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center mx-auto">2</div>
                            <p class="mt-2 text-xs">Review</p>
                        </div>

                        <span class="text-gray-400">→</span>

                        <div class="text-center">
                            <div class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center mx-auto">3</div>
                            <p class="mt-2 text-xs">Feedback</p>
                        </div>

                        <span class="text-gray-400">→</span>

                        <div class="text-center">
                            <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center mx-auto">4</div>
                            <p class="mt-2 text-xs">Final</p>
                        </div>

                    </div>
                </div>


                {{-- Previous Submissions --}}
                <div class="bg-white p-6 rounded-xl shadow-sm">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold">Previous Submissions</h3>

                        <a href="{{ route('ideas.index') }}"
                            class="text-sm text-indigo-600 hover:underline">
                            View All
                        </a>
                    </div>

                    <div class="space-y-4 text-sm">

                        @forelse($previousIdeas as $idea)

                        <div class="flex justify-between items-center">

                            <div>
                                <p class="font-medium">
                                    {{ Str::limit($idea->title, 25) }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ $idea->created_at->format('M d, Y') }}
                                </p>
                            </div>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @if($idea->status->value === 'approved') bg-green-100 text-green-700
                    @elseif($idea->status->value === 'rejected') bg-red-100 text-red-700
                    @elseif($idea->status->value === 'submitted') bg-purple-100 text-purple-700
                    @else bg-gray-100 text-gray-700
                    @endif">

                                {{ ucfirst($idea->status->value) }}

                            </span>

                        </div>

                        @empty
                        <p class="text-gray-400 text-sm">
                            No previous submissions.
                        </p>
                        @endforelse

                    </div>

                </div>


            </div>

        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-4 mt-8">

            <a href="{{ route('ideas.index') }}"
                class="px-6 py-2 bg-gray-200 rounded-lg">
                Cancel
            </a>

            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Save Draft
            </button>

        </div>

    </form>

</div>

@endsection