@extends('layouts.app')

@section('title', 'Submit Idea')
@section('page-title', 'Submit New Idea')

@section('content')

@php use Illuminate\Support\Str; @endphp

<div class="max-w-6xl mx-auto bg-white p-4 sm:p-6 lg:p-8 rounded-2xl shadow">

    <form method="POST"
        action="{{ route('ideas.store') }}"
        enctype="multipart/form-data">
        @csrf

        {{-- ================= MAIN GRID ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            {{-- ================= LEFT SECTION ================= --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Title --}}
                <div>
                    <label class="font-semibold">Title <span class="text-red-500">*</span></label>
                    <input type="text"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">

                    @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="font-semibold">Description <span class="text-red-500">*</span></label>
                    <textarea name="description"
                        rows="5"
                        class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">{{ old('description') }}</textarea>

                    @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SWOT --}}
                <div>
                    <label class="font-semibold">SWOT Analysis (Optional)</label>
                    <textarea name="swot"
                        rows="4"
                        placeholder="Strengths, Weaknesses, Opportunities, Threats..."
                        class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">{{ old('swot') }}</textarea>

                    @error('swot')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category & Impact --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">

                    {{-- Category --}}
                    <div>
                        <label>Category <span class="text-red-500">*</span></label>
                        <select name="category"
                            class="w-full border px-3 py-2 sm:px-4 sm:py-3 rounded-lg">
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

                    {{-- Impact --}}
                    <div>
                        <label>Impact Level <span class="text-red-500">*</span></label>

                        <div class="flex flex-wrap gap-4 mt-2 text-sm">

                            <label class="flex items-center gap-2">
                                <input type="radio" name="impact_level" value="low"
                                    {{ old('impact_level', $idea->impact_level ?? '') == 'low' ? 'checked' : '' }}>
                                Low
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="impact_level" value="medium"
                                    {{ old('impact_level', $idea->impact_level ?? '') == 'medium' ? 'checked' : '' }}>
                                Medium
                            </label>

                            <label class="flex items-center gap-2">
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
                <div class="border-2 border-dashed rounded-xl p-4 sm:p-6 text-center">
                    <p class="font-semibold mb-2">Upload Attachments (Max 5)</p>

                    <p class="text-sm text-gray-500 mb-3">
                        Supported: Images, Videos, Documents
                    </p>

                    <input type="file"
                        name="attachments[]"
                        multiple
                        class="w-full text-sm">

                    @error('attachments.*')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- ================= RIGHT SIDEBAR ================= --}}
            <div class="space-y-6">

                {{-- Guidelines --}}
                <div class="bg-yellow-50 p-4 sm:p-6 rounded-xl shadow-sm">
                    <h3 class="font-semibold mb-3">Idea Guidelines</h3>
                    <ul class="text-sm space-y-2 text-gray-600">
                        <li>• Be clear and specific</li>
                        <li>• Add images/videos for clarity</li>
                        <li>• Mention expected benefits</li>
                        <li>• Avoid sensitive data</li>
                    </ul>
                </div>

                {{-- Review Process --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm">

                    <h3 class="font-semibold mb-4">🔄 Review Process</h3>

                    <div class="flex flex-wrap items-center justify-between gap-4 text-xs sm:text-sm">

                        @foreach(['Submitted','Review','Feedback','Final'] as $index => $step)
                        <div class="text-center flex-1">
                            <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center
                                {{ ['bg-purple-500','bg-blue-500','bg-yellow-500','bg-green-500'][$index] }} text-white">
                                {{ $index+1 }}
                            </div>
                            <p class="mt-2">{{ $step }}</p>
                        </div>
                        @endforeach

                    </div>

                </div>

                {{-- Previous Submissions --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold">Previous</h3>

                        <a href="{{ route('ideas.index') }}"
                            class="text-sm text-indigo-600">
                            View All
                        </a>
                    </div>

                    <div class="space-y-3 text-sm">

                        @forelse($previousIdeas as $idea)
                        <div class="flex justify-between items-center gap-2">

                            <div class="min-w-0">
                                <p class="font-medium truncate max-w-[150px]">
                                    {{ Str::limit($idea->title, 25) }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $idea->created_at->format('M d, Y') }}
                                </p>
                            </div>

                            <span class="px-2 py-1 rounded text-xs
                                @if($idea->status->value === 'approved') bg-green-100 text-green-700
                                @elseif($idea->status->value === 'rejected') bg-red-100 text-red-700
                                @elseif($idea->status->value === 'submitted') bg-purple-100 text-purple-700
                                @else bg-gray-100 text-gray-700
                                @endif">

                                {{ ucfirst($idea->status->value) }}

                            </span>

                        </div>

                        @empty
                        <p class="text-gray-400 text-sm">No previous submissions.</p>
                        @endforelse

                    </div>

                </div>

            </div>

        </div>

        {{-- ================= BUTTONS ================= --}}
        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 mt-8">

            <a href="{{ route('ideas.index') }}"
                class="w-full sm:w-auto text-center px-4 py-2 bg-gray-200 rounded-lg">
                Cancel
            </a>

            <button type="submit"
                class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Save Draft
            </button>

        </div>

    </form>

</div>

@endsection