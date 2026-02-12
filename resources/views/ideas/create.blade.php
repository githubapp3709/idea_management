@extends('layouts.app')

@section('title', 'Submit Idea')
@section('page-title', 'Submit New Idea')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

    <form method="POST" action="{{ route('ideas.store') }}">
        @csrf

        {{-- Title --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Title</label>
            <input type="text"
                   name="title"
                   value="{{ old('title') }}"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                   required>
            @error('title')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description"
                      rows="4"
                      class="w-full border rounded px-3 py-2 focus:outline-none focus:ring"
                      required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Category</label>
            <select name="category"
                    class="w-full border rounded px-3 py-2">
                <option value="">Select category</option>
                <option value="HR">HR</option>
                <option value="Tech">Tech</option>
                <option value="Process">Process</option>
                <option value="Sales">Sales</option>
            </select>
            @error('category')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Impact Level --}}
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Impact Level</label>
            <select name="impact_level"
                    class="w-full border rounded px-3 py-2"
                    required>
                <option value="">Select impact</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            @error('impact_level')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('ideas.index') }}"
               class="px-4 py-2 bg-gray-200 rounded">
                Cancel
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Save Draft
            </button>
        </div>

    </form>

</div>

@endsection
