@extends('layouts.app')

@section('title', 'Edit Team')
@section('page-title', 'Edit Team')

@section('content')

<div x-data="teamEditor()" class="max-w-6xl mx-auto bg-white p-8 rounded shadow">

    <form method="POST" action="{{ route('teams.update', $team) }}">
        @csrf
        @method('PUT')

        {{-- Team Name --}}
        <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">Team Name</label>
            <input type="text"
                name="name"
                value="{{ old('name', $team->name) }}"
                class="w-full border rounded px-4 py-2"
                required>
        </div>

        {{-- Search --}}
        <div class="mb-4">
            <input type="text"
                x-model="search"
                placeholder="Search Employees..."
                class="w-full border rounded px-4 py-2">
        </div>

        {{-- Dual Panel --}}

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="grid grid-cols-3 gap-6">

            {{-- Available --}}
            <div class="border rounded p-4">
                <h3 class="font-semibold mb-4">Available Employees</h3>

                <template x-for="employee in filteredAvailable()" :key="employee.id">
                    <div class="flex justify-between items-center mb-2">
                        <span x-text="employee.name"></span>
                        <button type="button"
                            @click="addMember(employee)"
                            class="text-green-600 font-bold">
                            →
                        </button>
                    </div>
                </template>
            </div>

            <div class="flex items-center justify-center text-2xl text-gray-400">
                ⇄
            </div>

            {{-- Selected --}}
            <div class="border rounded p-4">
                <h3 class="font-semibold mb-4">Team Members</h3>

                <template x-for="member in selected" :key="member.id">
                    <div class="flex justify-between items-center mb-2">

                        <div class="flex items-center gap-2">
                            <input type="radio"
                                name="leader_id"
                                :value="member.id"
                                :checked="member.id == {{ $team->team_lead_id ?? 'null' }}">
                            <span x-text="member.name"></span>
                        </div>

                        <button type="button"
                            @click="removeMember(member)"
                            class="text-red-600 font-bold">
                            ←
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

        <div class="mt-8 text-center">
            <button type="submit"
                class="px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700">
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