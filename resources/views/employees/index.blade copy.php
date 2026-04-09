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

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 mb-6">

    {{-- Total --}}
    <a href="{{ route('employees.index') }}"
        class="bg-white shadow rounded p-4 border hover:bg-gray-50 flex items-center gap-3">

        <div class="p-2 bg-gray-100 rounded">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5V4H2v16h5m10 0v-6H7v6m10 0H7" />
            </svg>
        </div>

        <div>
            <p class="text-gray-500 text-sm font-bold">Total</p>
            <h2 class="text-xl font-bold">{{ $stats['total'] }}</h2>
        </div>
    </a>

    {{-- Active --}}
    <a href="{{ route('employees.index', ['status' => 'active']) }}"
        class="bg-green-50 shadow rounded p-4 border border-green-200 hover:bg-green-100 flex items-center gap-3">

        <div class="p-2 bg-green-200 rounded">
            <svg class="w-6 h-6 text-green-800" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <div>
            <p class="text-green-700 text-sm font-bold">Active</p>
            <h2 class="text-xl font-bold text-green-800">
                {{ $stats['active'] }}
            </h2>
        </div>
    </a>

    {{-- Inactive --}}
    <a href="{{ route('employees.index', ['status' => 'inactive']) }}"
        class="bg-red-50 shadow rounded p-4 border border-red-200 hover:bg-red-100 flex items-center gap-3">

        <div class="p-2 bg-red-200 rounded">
            <svg class="w-6 h-6 text-red-800" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <div>
            <p class="text-red-700 text-sm font-bold">Inactive</p>
            <h2 class="text-xl font-bold text-red-800">
                {{ $stats['inactive'] }}
            </h2>
        </div>
    </a>

    {{-- Assigned --}}
    <a href="{{ route('employees.index', ['assigned' => 1]) }}"
        class="bg-blue-50 shadow rounded p-4 border border-blue-200 hover:bg-blue-100 flex items-center gap-3">

        <div class="p-2 bg-blue-200 rounded">
            <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4" />
            </svg>
        </div>

        <div>
            <p class="text-blue-700 text-sm font-bold">Assigned</p>
            <h2 class="text-xl font-bold text-blue-800">
                {{ $stats['assigned'] }}
            </h2>
        </div>
    </a>

    {{-- Unassigned --}}
    <a href="{{ route('employees.index', ['assigned' => 0]) }}"
        class="bg-yellow-50 shadow rounded p-4 border border-yellow-200 hover:bg-yellow-100 flex items-center gap-3">

        <div class="p-2 bg-yellow-200 rounded">
            <svg class="w-6 h-6 text-yellow-800" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01" />
            </svg>
        </div>

        <div>
            <p class="text-yellow-700 text-sm font-bold">Unassigned</p>
            <h2 class="text-xl font-bold text-yellow-800">
                {{ $stats['unassigned'] }}
            </h2>
        </div>
    </a>

    {{-- Team Leads --}}
    <a href="{{ route('employees.index', ['role' => 'team_lead']) }}"
        class="bg-purple-50 shadow rounded p-4 border border-purple-200 hover:bg-purple-100 flex items-center gap-3">

        <div class="p-2 bg-purple-200 rounded">
            <svg class="w-6 h-6 text-purple-800" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <div>
            <p class="text-purple-700 text-sm font-bold">Leaders</p>
            <h2 class="text-xl font-bold text-purple-800">
                {{ $stats['team_leads'] }}
            </h2>
        </div>
    </a>

</div>


@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="mb-4 flex gap-3">

    <form method="POST"
        action="{{ route('employees.import') }}"
        enctype="multipart/form-data"
        class="flex gap-2">
        @csrf
        <input type="file" name="file" required>
        <button class="bg-blue-600 text-white px-3 py-1 text-sm rounded">
            Import CSV
        </button>
    </form>

    <a href="{{ route('employees.template') }}"
        class="bg-indigo-600 text-white px-3 py-1 text-sm rounded">
        Download Template
    </a>


    <a href="{{ route('employees.export') }}"
        class="bg-gray-600 text-white px-3 py-1 text-sm rounded">
        Export CSV
    </a>

</div>




<div class="flex justify-between">
    <form method="GET" class="mb-4 flex gap-3 items-center">

        {{-- Search --}}
        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search employees..."
            class="border px-3 py-1 text-sm rounded">

        {{-- Role --}}
        <select name="role"
            class="border px-3 py-1 text-sm rounded">
            <option value="">Roles</option>
            @foreach($roles as $role)
            <option value="{{ $role->name }}"
                {{ request('role') == $role->name ? 'selected' : '' }}>
                {{ ucfirst($role->name) }}
            </option>
            @endforeach
        </select>

        {{-- Team --}}
        <select name="team"
            class="border px-3 py-1 text-sm rounded">
            <option value="">Teams</option>
            @foreach($teams as $team)
            <option value="{{ $team->id }}"
                {{ request('team') == $team->id ? 'selected' : '' }}>
                {{ $team->name }}
            </option>
            @endforeach
        </select>

        {{-- Status --}}
        <select name="status"
            class="border px-3 py-1 text-sm rounded">
            <option value="">Status </option>
            <option value="active"
                {{ request('status') == 'active' ? 'selected' : '' }}>
                Active
            </option>
            <option value="inactive"
                {{ request('status') == 'inactive' ? 'selected' : '' }}>
                In-active
            </option>
        </select>

        <button class="bg-indigo-600 text-white px-3 py-1 text-sm rounded">
            Filter
        </button>

        <a href="{{ route('employees.index') }}"
            class="bg-gray-600 text-white px-3 py-1 text-sm rounded">
            Reset
        </a>

    </form>

    <div>
        <a href="{{ route('employees.create') }}" class="bg-indigo-600 text-white px-3 py-1 text-sm rounded flex justify-end">Add Employee</a>

    </div>
</div>




<form method="POST" action="{{ route('employees.bulkDelete') }}" onsubmit="return confirm('Are you sure you want to delete selected employees?')">
    @csrf
    @method('DELETE')

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded border text-center text-sm">

            {{-- Table Header --}}
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 border border-gray-300">
                        <input type="checkbox" id="selectAll">
                    </th>

                    <th class="px-4 py-3 border border-gray-300">
                        <a href="{{ sortUrl('name') }}" class="flex justify-center items-center gap-1">
                            Name
                            @if(request('sort') === 'name')
                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                            @endif
                        </a>
                    </th>

                    <th class="px-4 py-3 border border-gray-300">
                        <a href="{{ sortUrl('emp_code') }}" class="flex justify-center items-center gap-1">
                            Emp Code
                            @if(request('sort') === 'emp_code')
                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                            @endif
                        </a>
                    </th>

                    <th class="px-4 py-3 border border-gray-300">
                        <a href="{{ sortUrl('email') }}" class="flex justify-center items-center gap-1">
                            Email
                            @if(request('sort') === 'email')
                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                            @endif
                        </a>
                    </th>



                    <th class="px-4 py-3 border border-gray-300">
                        <a href="{{ sortUrl('employee_code') }}" class="flex justify-center items-center gap-1">
                            Designation
                            @if(request('sort') === 'employee_code')
                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                            @endif
                        </a>
                    </th>

                    <th class="px-4 py-3 border border-gray-300">
                        <a href="{{ sortUrl('team') }}" class="flex justify-center items-center gap-1">
                            Team
                            @if(request('sort') === 'team')
                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                            @endif
                        </a>
                    </th>

                    <th class="px-4 py-3 border border-gray-300">
                        <a href="{{ sortUrl('status') }}" class="flex justify-center items-center gap-1">
                            Status
                            @if(request('sort') === 'status')
                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                            @endif
                        </a>
                    </th>

                    <th class="px-4 py-3 border border-gray-300">
                        <a href="{{ sortUrl('created_at') }}" class="flex justify-center items-center gap-1">
                            Created
                            @if(request('sort') === 'created_at')
                            {{ request('direction') === 'asc' ? '↑' : '↓' }}
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 border border-gray-300">
                        Action
                    </th>
                </tr>
            </thead>

            {{-- Table Body --}}
            <tbody>
                @foreach($employees as $employee)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="px-4 py-3 border border-gray-300">
                        <input type="checkbox"
                            name="ids[]"
                            value="{{ $employee->id }}"
                            class="rowCheckbox">
                    </td>
                    <td class="px-4 py-3 border border-gray-300 font-medium">
                        <div class="flex items-center gap-4">

                            <!-- Profile Image -->
                            <div class="w-12 h-12 rounded-full overflow-hidden shadow">
                                <img
                                    src="{{ $employee->profile_image_url ?? asset('images/default-user.jpg') }}"
                                    class="w-full h-full object-cover">
                            </div>

                            <!-- Employee Name -->
                            <span class="text-gray-800 font-semibold" title="{{ $employee->name }}">                                
                                {{ Str::limit($employee->name, 10) }}
                            </span>

                        </div>

                    </td>
                    <td class="px-4 py-3 border border-gray-300 font-medium" title="{{ $employee->employee_code }}">{{ \Illuminate\Support\Str::limit($employee->employee_code, 7) }}</td>
                    <td class="px-4 py-3 border border-gray-300" title="{{ $employee->email }}">{{ \Illuminate\Support\Str::limit($employee->email, 10) }}</td>
                    <td class="px-4 py-3 border border-gray-300">{{ $employee->role?->name }}</td>
                    <td class="px-4 py-3 border border-gray-300" title="{{ $employee->team?->name ?? '-' }}">{{ \Illuminate\Support\Str::limit($employee->name, 7) }}</td>
                    <td class="px-4 py-3 border border-gray-300">
                        <span class="px-2 py-1 rounded text-xs 
                                {{ $employee->status === 'active' 
                                    ? 'bg-green-100 text-green-700' 
                                    : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 border border-gray-300">
                        {{ $employee->created_at->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 border border-gray-300 align-middle text-center">

    <div class="flex items-center justify-center gap-2 h-full">

        {{-- View --}}
        <a href="{{ route('employee.show', $employee) }}"
            class="text-indigo-600 hover:text-indigo-800 transition"
            title="View">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M1.5 12s4.5-7.5 10.5-7.5S22.5 12 22.5 12
                       18 19.5 12 19.5 1.5 12 1.5 12z" />

                <circle cx="12" cy="12" r="3" stroke-width="2" />
            </svg>
        </a>

        {{-- Edit --}}
        <a href="{{ route('employees.edit', $employee) }}"
            class="text-yellow-600 hover:text-yellow-800 transition"
            title="Edit">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M11 4H6a2 2 0 00-2 2v11a2 2 0 002 2h11
                       a2 2 0 002-2v-5M16.5 3.5a2.121
                       2.121 0 113 3L12 14l-4 1 1-4
                       7.5-7.5z" />
            </svg>
        </a>

        {{-- Delete --}}
        <button type="button"
            onclick="deleteEmployee({{ $employee->id }})"
            class="text-red-600 hover:text-red-800 transition"
            title="Delete">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                       a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                       M1 7h22M9 3h6a1 1 0 011 1v2H8V4
                       a1 1 0 011-1z" />
            </svg>
        </button>

    </div>

</td>


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Delete Button --}}
    <div class="mt-4 text-left">
        <button class="bg-red-600 text-white px-3 py-1 text-sm rounded hover:bg-red-700 transition">
            Delete Selected
        </button>
    </div>

</form>

<form id="deleteEmployeeForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<div class="mt-4">
    {{ $employees->links() }}
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