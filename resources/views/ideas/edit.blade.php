@extends('layouts.app')

@section('title', 'Edit Idea')
@section('page-title', 'Edit Idea')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

    {{-- Status Info --}}
    <div class="mb-4 p-3 bg-gray-100 rounded text-sm">
        <strong>Status:</strong>
        <span class="capitalize">{{ $idea->status->value }}</span>
    </div>

    {{-- UPDATE FORM --}}
    <form method="POST" action="{{ route('ideas.update', $idea) }}">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Title</label>
            <input type="text"
                   name="title"
                   value="{{ old('title', $idea->title) }}"
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
                      required>{{ old('description', $idea->description) }}</textarea>
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
                @foreach(['HR','Tech','Process','Sales'] as $category)
                    <option value="{{ $category }}"
                        {{ old('category', $idea->category) === $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
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
                @foreach(['low','medium','high'] as $level)
                    <option value="{{ $level }}"
                        {{ old('impact_level', $idea->impact_level) === $level ? 'selected' : '' }}>
                        {{ ucfirst($level) }}
                    </option>
                @endforeach
            </select>
            @error('impact_level')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex justify-between items-center">

            <a href="{{ route('ideas.index') }}"
               class="px-4 py-2 bg-gray-200 rounded">
                Back
            </a>

            <div class="flex gap-3">

                {{-- Update --}}
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Update
                </button>

            </div>
        </div>
    </form>

    {{-- SUBMIT FORM --}}
    @can('submit', $idea)
        <div class="flex justify-center mt-4">
            <form method="POST"
                  action="{{ route('ideas.submit', $idea) }}"
                  onsubmit="return confirm('Submit this idea for review? You will not be able to edit it after submission.')">
                @csrf
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Submit
                </button>
            </form>
        </div>
    @endcan
</div>


@endsection