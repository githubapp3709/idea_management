@php
function sortUrl($column) {
$direction = request('sort') === $column && request('direction') === 'asc'
? 'desc'
: 'asc';

return request()->fullUrlWithQuery([
'sort' => $column,
'direction' => $direction
]);
}
@endphp

@extends('layouts.app')

@section('title', 'Employee Management')
@section('page-title', 'Employee Management')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- ================= STATS ================= --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

        {{-- Total --}}
        <a href="{{ route('employees.index') }}"
            class="bg-white shadow rounded p-4 border hover:bg-gray-50 flex items-center gap-3 w-full">

            <div class="p-2 bg-gray-100 rounded shrink-0">
                <img src="{{ asset('images/total employee.png') }}" alt="">
            </div>

            <div class="min-w-0">
                <p class="text-xs font-semibold text-gray-600">Total</p>
                <h2 class="text-base sm:text-lg font-bold truncate">{{ $stats['total'] }}</h2>
            </div>
        </a>

        {{-- Active --}}
        <a href="{{ route('employees.index', ['status' => 'active']) }}"
            class="bg-green-50 shadow rounded p-4 border border-green-200 hover:bg-green-100 flex items-center gap-3 w-full">

            <div class="p-2 bg-green-200 rounded shrink-0">
                <img src="{{ asset('images/active employees.png') }}" alt="">
            </div>

            <div class="min-w-0">
                <p class="text-xs font-semibold text-green-700">Active</p>
                <h2 class="text-base sm:text-lg font-bold text-green-800">
                    {{ $stats['active'] }}
                </h2>
            </div>
        </a>

        {{-- Inactive --}}
        <a href="{{ route('employees.index', ['status' => 'inactive']) }}"
            class="bg-red-50 shadow rounded p-4 border border-red-200 hover:bg-red-100 flex items-center gap-3 w-full">

            <div class="p-2 bg-red-200 rounded shrink-0">
                <img src="{{ asset('images/inactive employees.png') }}" alt="">
            </div>

            <div class="min-w-0">
                <p class="text-xs font-semibold text-red-700">Inactive</p>
                <h2 class="text-base sm:text-lg font-bold text-red-800">
                    {{ $stats['inactive'] }}
                </h2>
            </div>
        </a>

        {{-- Assigned --}}
        <a href="{{ route('employees.index', ['assigned' => 1]) }}"
            class="bg-blue-50 shadow rounded p-4 border border-blue-200 hover:bg-blue-100 flex items-center gap-3 w-full">

            <div class="p-2 bg-blue-200 rounded shrink-0">
                <img src="{{ asset('images/assigned.png') }}" alt="">
            </div>

            <div class="min-w-0">
                <p class="text-xs font-semibold text-blue-700">Assigned</p>
                <h2 class="text-base sm:text-lg font-bold text-blue-800">
                    {{ $stats['assigned'] }}
                </h2>
            </div>
        </a>

        {{-- Unassigned --}}
        <a href="{{ route('employees.index', ['assigned' => 0]) }}"
            class="bg-yellow-50 shadow rounded p-4 border border-yellow-200 hover:bg-yellow-100 flex items-center gap-3 w-full">

            <div class="p-2 bg-yellow-200 rounded shrink-0">
                <img src="{{ asset('images/unassigned.png') }}" alt="">
            </div>

            <div class="min-w-0">
                <p class="text-xs font-semibold text-yellow-700">Unassigned</p>
                <h2 class="text-base sm:text-lg font-bold text-yellow-800">
                    {{ $stats['unassigned'] }}
                </h2>
            </div>
        </a>

        {{-- Team Leads --}}
        <a href="{{ route('employees.index', ['role' => 'team_lead']) }}"
            class="bg-purple-50 shadow rounded p-4 border border-purple-200 hover:bg-purple-100 flex items-center gap-3 w-full">

            <div class="p-2 bg-purple-200 rounded shrink-0">
                <img src="{{ asset('images/team lead.png') }}" alt="">
            </div>

            <div class="min-w-0">
                <p class="text-xs font-semibold text-purple-700">Leaders</p>
                <h2 class="text-base sm:text-lg font-bold text-purple-800">
                    {{ $stats['team_leads'] }}
                </h2>
            </div>
        </a>

    </div>

    {{-- ================= IMPORT / EXPORT ================= --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 bg-white py-3 px-3 rounded">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">
            Import / Export
        </h3>
        {{-- LEFT: Template + File --}}
        <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

            {{-- Template --}}
            <a href="{{ route('employees.template') }}"
                class="w-full sm:w-auto text-center bg-indigo-600 text-white px-3 py-2 text-sm rounded">
                Template
            </a>

            {{-- File Input --}}
            <form method="POST"
                action="{{ route('employees.import') }}"
                enctype="multipart/form-data"
                class="flex sm:flex-row gap-3 w-full sm:w-auto">
                @csrf

                <input type="file" name="file" class="w-full sm:w-auto border rounded px-2 py-1">

                {{-- Import Button --}}
                <button class="w-full sm:w-auto bg-blue-600 text-white px-3 py-2 text-sm rounded">
                    Import CSV
                </button>
            </form>

        </div>

        {{-- RIGHT: Export --}}
        <div class="flex gap-3 w-full lg:w-auto">

            <a href="{{ route('employees.export') }}"
                class="w-full sm:w-auto text-center bg-gray-600 text-white px-3 py-2 text-sm rounded">
                Export
            </a>

            <a href="{{ route('employees.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded text-center w-full sm:w-auto">
                Add Employee
            </a>
        </div>
    </div>

    {{-- ================= FILTER ================= --}}
    <div>

        <form method="GET"
            class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 bg-white py-3 px-3 rounded">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">
                Filter
            </h3>
            <div class="flex gap-3 w-full">
                {{-- Search --}}
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search..."
                    class="app-input border px-3 py-2 rounded">

                {{-- Role --}}
                <select name="role"
                    class="border px-3 py-2 rounded w-full">
                    <option value="">Roles</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 w-full">
                {{-- Team --}}
                <select name="team"
                    class="app-input border px-3 py-2 rounded">
                    <option value="">Teams</option>
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ request('team') == $team->id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                    @endforeach
                </select>

                {{-- Status --}}
                <select name="status"
                    class="app-input border px-3 py-2 rounded">
                    <option value="">Status</option>
                    <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 w-full">
                <button class="app-input border px-3 py-2 rounded bg-indigo-600 text-white">
                    Filter
                </button>

                <a href="{{ route('employees.index') }}"
                    class="app-input border px-3 py-2 rounded bg-gray-600 text-white text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ================= TABLE ================= --}}
    <form method="POST"
        action="{{ route('employees.bulkDelete') }}"
        onsubmit="return confirm('Delete selected employees?')">
        @csrf
        @method('DELETE')

        <div class="overflow-x-auto">

            <table class="min-w-full bg-white shadow rounded border text-sm">

                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-3 py-2 sm:px-4 border"><input type="checkbox" id="selectAll"></th>
                        <th class="px-3 py-2 sm:px-4 border">Name</th>
                        <th class="px-3 py-2 sm:px-4 border">Code</th>
                        <th class="px-3 py-2 sm:px-4 border">Email</th>
                        <th class="px-3 py-2 sm:px-4 border">Role</th>
                        <th class="px-3 py-2 sm:px-4 border">Team</th>
                        <th class="px-3 py-2 sm:px-4 border">Status</th>
                        <th class="px-3 py-2 sm:px-4 border">Created</th>
                        <th class="px-3 py-2 sm:px-4 border">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($employees as $employee)
                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-3 py-2 sm:px-4 border">
                            <input type="checkbox" name="ids[]" value="{{ $employee->id }}">
                        </td>

                        <td class="px-3 py-2 sm:px-4 border">
                            <div class="flex items-center gap-2">
                                <img src="{{ $employee->profile_image_url ?? asset('images/default-user.jpg') }}"
                                    class="w-8 h-8 rounded-full object-cover">
                                <span class="truncate max-w-[120px]">
                                    {{ \Illuminate\Support\Str::limit($employee->name, 15) }}
                                </span>
                            </div>
                        </td>

                        <td class="px-3 py-2 sm:px-4 border">{{ $employee->employee_code }}</td>
                        <td class="px-3 py-2 sm:px-4 border truncate max-w-[140px]">{{ $employee->email }}</td>
                        <td class="px-3 py-2 sm:px-4 border">{{ $employee->role?->name }}</td>
                        <td class="px-3 py-2 sm:px-4 border">{{ $employee->team?->name ?? '-' }}</td>

                        <td class="px-3 py-2 sm:px-4 border">
                            <span class="text-xs px-2 py-1 rounded
                                {{ $employee->status === 'active'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </td>

                        <td class="px-3 py-2 sm:px-4 border">
                            {{ $employee->created_at->format('d M Y') }}
                        </td>

                        <td class="px-3 py-2 sm:px-4 border">
                            <div class="flex flex-wrap gap-2 justify-center text-sm">
                                <a href="{{ route('employee.show', $employee) }}" class="text-indigo-600">View</a>
                                <a href="{{ route('employees.edit', $employee) }}" class="text-yellow-600">Edit</a>
                                <button type="button"
                                    onclick="deleteEmployee({{ $employee->id }})"
                                    class="text-red-600">Delete</button>
                            </div>
                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-4">
            <button class="w-full sm:w-auto bg-red-600 text-white px-4 py-2 rounded">
                Delete Selected
            </button>
        </div>

    </form>
    <form id="deleteEmployeeForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <div>
        {{ $employees->links() }}
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.rowCheckbox');

        if (selectAll) {
            selectAll.addEventListener('change', function() {

                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAll.checked;
                });

            });
        }

    });
</script>

<script>
    function deleteEmployee(id) {
        if (confirm('Are you sure you want to delete this employee?')) {
            let form = document.getElementById('deleteEmployeeForm');
            form.action = '/employee/' + id;
            form.submit();
        }
    }
</script>


@endsection