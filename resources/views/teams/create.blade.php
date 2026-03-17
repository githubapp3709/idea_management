@extends('layouts.app')

@section('title', 'Create Team')
@section('page-title', 'Create New Team')

@section('content')

<div x-data="teamBuilder()" class="max-w-6xl mx-auto bg-white p-10 rounded-2xl shadow-lg">

    <form method="POST" action="{{ route('teams.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Top Section --}}
        <div class="grid grid-cols-2 gap-10 mb-8">

            {{-- Upload Image --}}
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 flex items-center gap-6 bg-gray-50">

                <div class="w-20 h-20 bg-gradient-to-br from-green-200 to-blue-200 rounded-lg flex items-center justify-center">
                    📷
                </div>

                <div>
                    <p class="font-semibold text-lg">Upload Team Image</p>
                    <p class="text-sm text-gray-500">Choose an image to upload</p>
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, GIF up to 5MB</p>

                    <input type="file" name="image" class="mt-3 text-sm">
                </div>
            </div>

            {{-- Team Name --}}
            <div>
                <label class="block text-lg font-semibold mb-3">Team Name</label>
                <input type="text"
                       name="name"
                       placeholder="Enter team name"
                       class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                       required>
            </div>

        </div>

        {{-- Search --}}
        <div class="mb-6">
            <input type="text"
                   x-model="search"
                   placeholder="Search employees..."
                   class="w-full border rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        {{-- Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Dual Panel --}}
        <div class="grid grid-cols-3 gap-8">

            {{-- Available Employees --}}
            <div class="bg-gray-50 rounded-xl p-5 shadow-sm">
                <h3 class="font-semibold text-gray-700 mb-4">Available Employees</h3>

                <div class="space-y-3 max-h-72 overflow-y-auto">
                    <template x-for="employee in filteredAvailable()" :key="employee.id">
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">

                            <div class="flex items-center gap-3">
                                <input type="checkbox"
                                       @click="addMember(employee)"
                                       class="w-4 h-4">
                                <span x-text="employee.name"></span>
                            </div>

                        </div>
                    </template>
                </div>
            </div>

            {{-- Arrows --}}
            <div class="flex items-center justify-center text-3xl text-gray-400">
                ⇄
            </div>

            {{-- Selected Members --}}
            <div class="bg-gray-50 rounded-xl p-5 shadow-sm">

                <h3 class="font-semibold text-gray-700 mb-4">Your Team Members</h3>

                {{-- Choose Team Lead --}}
                <div class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg mb-4 text-sm flex items-center justify-between">
                    ⭐ Choose Team Lead
                </div>

                <div class="space-y-3 max-h-72 overflow-y-auto">
                    <template x-for="member in selected" :key="member.id">
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">

                            <div class="flex items-center gap-3">
                                <input type="radio"
                                       name="leader_id"
                                       :value="member.id"
                                       class="w-4 h-4">
                                <span x-text="member.name"></span>
                            </div>

                            <button type="button"
                                    @click="removeMember(member)"
                                    class="text-red-500 font-bold">
                                ✕
                            </button>

                            <input type="hidden"
                                   name="members[]"
                                   :value="member.id">
                        </div>
                    </template>

                    <p x-show="selected.length === 0"
                       class="text-gray-400 text-sm">
                        No members selected
                    </p>
                </div>

            </div>

        </div>

        {{-- Submit --}}
        <div class="mt-10 text-center">
            <button type="submit"
                    class="px-10 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow-md hover:scale-105 transition">
                Create Team
            </button>
        </div>

    </form>

</div>


<script>
    function teamBuilder() {
        return {
            search: '',
            available: @json($employees),
            selected: [],

            filteredAvailable() {
                return this.available.filter(e =>
                    e.name.toLowerCase().includes(this.search.toLowerCase())
                );
            },

            addMember(employee) {
                this.selected.push(employee);
                this.available = this.available.filter(e => e.id !== employee.id);
            },

            removeMember(member) {
                this.available.push(member);
                this.selected = this.selected.filter(e => e.id !== member.id);
            }
        }
    }
</script>

@endsection