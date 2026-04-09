@extends('layouts.app')

@section('title', 'Edit Team')
@section('page-title', 'Edit Team')

@section('content')

<div x-data="teamEditor()" class="max-w-6xl mx-auto bg-white p-4 sm:p-6 lg:p-10 rounded-2xl shadow-lg space-y-6">

    <form method="POST" action="{{ route('teams.update', $team) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ================= TOP SECTION ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            {{-- Image --}}
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 sm:p-6 flex flex-col sm:flex-row items-center gap-4 bg-gray-50">

                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg overflow-hidden shrink-0">
                    <img src="{{ $team->image_url }}"
                        class="w-full h-full object-cover">
                </div>

                <div class="text-center sm:text-left">
                    <p class="font-semibold">Update Team Image</p>
                    <p class="text-xs text-gray-500">JPG, PNG, GIF up to 5MB</p>

                    <input type="file" name="image" class="mt-2 text-sm w-full">
                </div>

            </div>

            {{-- Name --}}
            <div>
                <label class="block font-semibold mb-2">Team Name</label>
                <input type="text"
                    name="name"
                    value="{{ old('name', $team->name) }}"
                    class="w-full border rounded-lg px-3 py-2 sm:px-4 sm:py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    required>
            </div>

        </div>

        {{-- ================= SEARCH ================= --}}
        <div class="py-2">
            <input type="text"
                x-model="search"
                placeholder="Search employees..."
                class="w-full border rounded-xl px-4 py-2 sm:px-5 sm:py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        {{-- ================= ERRORS ================= --}}
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ================= DUAL PANEL ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Available --}}
            <div class="bg-gray-50 rounded-xl p-4 sm:p-5 shadow-sm">

                <h3 class="font-semibold mb-3">Available Employees</h3>

                <div class="space-y-2 max-h-60 overflow-y-auto">
                    <template x-for="employee in filteredAvailable()" :key="employee.id">
                        <div class="flex justify-between items-center bg-white p-2 sm:p-3 rounded shadow-sm">

                            <div class="flex items-center gap-2 sm:gap-3">
                                <input type="checkbox"
                                    @click="addMember(employee)"
                                    class="w-4 h-4">
                                <span class="text-sm sm:text-base" x-text="employee.name"></span>
                            </div>

                        </div>
                    </template>
                </div>

            </div>

            {{-- Arrow --}}
            <div class="hidden lg:flex items-center justify-center text-2xl text-gray-400">
                ⇄
            </div>

            {{-- Selected --}}
            <div class="bg-gray-50 rounded-xl p-4 sm:p-5 shadow-sm">

                <h3 class="font-semibold mb-3">Team Members</h3>

                <div class="bg-indigo-100 text-indigo-700 px-3 py-2 rounded mb-3 text-xs sm:text-sm text-center">
                    ⭐ Select Team Leader
                </div>

                <div class="space-y-2 max-h-60 overflow-y-auto">

                    <template x-for="member in selected" :key="member.id">
                        <div class="flex justify-between items-center bg-white p-2 sm:p-3 rounded shadow-sm">

                            <div class="flex items-center gap-2 sm:gap-3">
                                <input type="radio"
                                    name="leader_id"
                                    :value="member.id"
                                    :checked="member.id == {{ $team->team_lead_id ?? 'null' }}"
                                    class="w-4 h-4">
                                <span class="text-sm sm:text-base" x-text="member.name"></span>
                            </div>

                            <button type="button"
                                @click="removeMember(member)"
                                class="text-red-500 text-sm">
                                ✕
                            </button>

                            <input type="hidden"
                                name="members[]"
                                :value="member.id">
                        </div>
                    </template>

                    <p x-show="selected.length === 0"
                        class="text-gray-400 text-sm text-center">
                        No members selected
                    </p>

                </div>

            </div>

        </div>

        {{-- ================= SUBMIT ================= --}}
        <div class="mt-6">

            <button type="submit"
                class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow hover:scale-105 transition">
                Update Team
            </button>

        </div>

    </form>

</div>

<script>
function teamEditor() {
    return {
        search: '',
        available: @json($availableEmployees),
        selected: @json($selectedMembers),

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