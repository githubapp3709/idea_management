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
                    </div>

                </div>

                {{-- ========================= --}}
                {{-- EXISTING ATTACHMENTS --}}
                {{-- ========================= --}}

                {{-- Images --}}

                @if($idea->attachments->where('file_type','image')->count())
                <div>
                    <h3 class="font-semibold mb-3">Uploaded Images</h3>

                    <div class="space-y-3">
                        @foreach($idea->attachments->where('file_type','image')->values() as $image)

                        <div class="relative group border rounded-lg p-3 flex justify-between items-center">

                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/'.$image->file_path) }}"
                                    class="w-16 h-16 object-cover rounded">

                                <span>
                                    🖼 {{ basename($image->file_path) }}
                                </span>
                            </div>

                            {{-- DELETE BUTTON --}}
                            <button type="button"
                                onclick="deleteAttachment({{ $image->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                Remove
                            </button>

                        </div>

                        @endforeach
                    </div>
                </div>
                @endif




                {{-- Videos --}}
                @if($idea->attachments->where('file_type','video')->count())
                <div>
                    <h3 class="font-semibold mb-3 mt-6">Uploaded Videos</h3>

                    <div class="space-y-3">
                        @foreach($idea->attachments->where('file_type','video')->values() as $video)

                        <div class="relative group border rounded-lg p-4 flex justify-between items-center">

                            <div>
                                🎥 {{ basename($video->file_path) }}
                            </div>

                            {{-- DELETE BUTTON --}}
                            <button type="button"
                                onclick="deleteAttachment({{ $video->id }})"
                                class="bg-red-600 text-white px-3 py-1 rounded opacity-0 group-hover:opacity-100 transition">
                                Remove
                            </button>

                        </div>

                        @endforeach
                    </div>
                </div>
                @endif



                {{-- ========================= --}}
                {{-- UPLOAD NEW FILES --}}
                {{-- ========================= --}}

                <div class="grid grid-cols-2 gap-6 mt-6">
                    {{-- Upload Images --}}
                    <div class="border-2 border-dashed rounded-xl p-6 text-center">
                        <p class="font-semibold mb-2">Upload More Images (Max 5)</p>

                        <input type="file"
                            name="images[]"
                            multiple
                            accept="image/*"
                            class="w-full">

                        @error('images.*')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Videos --}}
                    <div class="border-2 border-dashed rounded-xl p-6 text-center">
                        <p class="font-semibold mb-2">Upload More Videos (Max 2)</p>

                        <input type="file"
                            name="videos[]"
                            multiple
                            accept="video/mp4,video/mov"
                            class="w-full">

                        @error('videos.*')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="space-y-6">

                <div class="bg-yellow-50 p-6 rounded-xl shadow-sm">
                    <h3 class="font-semibold mb-3">Edit Guidelines</h3>
                    <ul class="text-sm space-y-2 text-gray-600">
                        <li>• You can edit only Draft ideas</li>
                        <li>• You cannot edit after submission</li>
                        <li>• Max 5 images & 2 videos</li>
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

</div>

</form>


{{-- Buttons --}}
<div class="flex justify-between items-center mt-8">

    {{-- Delete Button --}}
    @if($idea->status->value === 'draft')
    <form method="POST"
          action="{{ route('ideas.destroy', $idea) }}"
          onsubmit="return confirm('Are you sure you want to delete this draft idea?');">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Delete Draft
        </button>
    </form>
    @endif

    {{-- Right Side Buttons --}}
    <div class="flex gap-4">
        <a href="{{ route('ideas.index') }}"
           class="px-6 py-2 bg-gray-200 rounded-lg">
            Cancel
        </a>

        <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Update Draft
        </button>
    </div>

</div>

<form id="deleteAttachmentForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>


</div>


<script>
    function deleteAttachment(id) {
        if (confirm('Remove this attachment?')) {

            let form = document.getElementById('deleteAttachmentForm');
            form.action = "/ideas/attachments/" + id;
            form.submit();
        }
    }
</script>


@endsection