@extends('layouts.app')

@section('title', 'Edit Idea')
@section('page-title', 'Edit Idea')

@section('content')

<div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow">

    <form method="POST"
        action="{{ route('ideas.update', $idea) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-3 gap-8">

            {{-- LEFT SECTION --}}
            <div class="col-span-2 space-y-6">
                @if($idea->review_remark)
                <div>
                    <label class="font-semibold">Feedback</label>
                    <span class="w-full border px-4 py-3 rounded-lg flex items-center text-sm font-medium bg-yellow-100 text-yellow-800">
                         {{$idea->review_remark}}
                    </span>
                </div>
                @endif
                {{-- Title --}}
                <div>
                    <label class="font-semibold">Title *</label>
                    <input type="text"
                        name="title"
                        value="{{ old('title', $idea->title) }}"
                        class="w-full border px-4 py-3 rounded-lg">
                    @error('title')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="font-semibold">Description *</label>
                    <textarea name="description"
                        rows="5"
                        class="w-full border px-4 py-3 rounded-lg">{{ old('description', $idea->description) }}</textarea>
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
                        class="w-full border px-4 py-3 rounded-lg">{{ old('swot', $idea->swot) }}</textarea>
                    @error('swot')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category & Impact --}}
                <div class="grid grid-cols-2 gap-6">

                    <div>
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

                    <div>
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

                {{-- ========================= --}}
                {{-- EXISTING ATTACHMENTS --}}
                {{-- ========================= --}}

                @if($idea->attachments->count())
                <div>
                    <h3 class="font-semibold mb-3">Uploaded Attachments</h3>

                    <div class="space-y-3">

                        @foreach($idea->attachments as $file)

                        <div class="relative group border rounded-lg p-3 flex justify-between items-center">

                            <div class="flex items-center gap-3">

                                {{-- IMAGE --}}
                                @if($file->file_type === 'image')
                                <img src="{{ asset('storage/'.$file->file_path) }}"
                                    class="w-16 h-16 object-cover rounded">
                                @endif

                                {{-- VIDEO --}}
                                @if($file->file_type === 'video')
                                <span class="text-lg">🎥</span>
                                @endif

                                {{-- DOCUMENT --}}
                                @if($file->file_type === 'document')
                                <span class="text-lg">📄</span>
                                @endif

                                <span>
                                    {{ basename($file->file_path) }}
                                </span>

                            </div>

                            {{-- DELETE --}}
                            <button type="button"
                                onclick="deleteAttachment({{ $file->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                Remove
                            </button>

                        </div>

                        @endforeach

                    </div>
                </div>
                @endif


                {{-- ========================= --}}
                {{-- UPLOAD ATTACHMENTS --}}
                {{-- ========================= --}}

                <div class="border-2 border-dashed rounded-xl p-6 text-center mt-6">

                    <p class="font-semibold mb-2">
                        Upload Attachments (Max 5)
                    </p>

                    <p class="text-sm text-gray-500 mb-2">
                        Images, Videos, Documents allowed
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
                    <h3 class="font-semibold mb-3">Edit Guidelines</h3>
                    <ul class="text-sm space-y-2 text-gray-600">
                        <li>• You can edit only Draft ideas</li>
                        <li>• You cannot edit after submission</li>
                        <li>• Max 5 attachments</li>
                    </ul>
                </div>

            </div>

        </div>

        {{-- Buttons --}}
        <div class="flex justify-between items-center mt-8">

            {{-- Delete --}}
            @if($idea->status->value === 'draft')
            <button type="button"
                onclick="deleteIdea()"
                class="px-6 py-2 bg-red-600 text-white rounded-lg">
                Delete Draft
            </button>
            @endif

            {{-- Update --}}
            <div class="flex gap-4">
                <a href="{{ route('ideas.index') }}"
                    class="px-6 py-2 bg-gray-200 rounded-lg">
                    Cancel
                </a>

                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg">
                    Update Draft
                </button>
            </div>

        </div>

    </form>


</div>

<form id="deleteIdeaForm"
    method="POST"
    action="{{ route('ideas.destroy', $idea) }}"
    class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- DELETE ATTACHMENT FORM --}}
<form id="deleteAttachmentForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteAttachment(id) {
        if (confirm('Remove this attachment?')) {
            let form = document.getElementById('deleteAttachmentForm');
            form.action = "/ideas/attachments/" + id;
            form.submit();
        }
    }

    function deleteIdea() {
        if (confirm('Are you sure you want to delete this draft idea?')) {
            document.getElementById('deleteIdeaForm').submit();
        }
    }
</script>
@endsection