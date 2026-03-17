<?php

namespace App\Modules\Employee\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
    public function getEmployees(Request $request)
    {
        $query = User::with(['role', 'team']);

        if ($request->assigned === '1') {
            $query->whereNotNull('team_id');
        }

        if ($request->assigned === '0') {
            $query->whereNull('team_id');
        }
        // 🔍 Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('employee_code', 'like', "%{$request->search}%");
            });
        }

        // 🎭 Role filter
        if ($request->role) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // 👥 Team filter
        if ($request->team) {
            $query->whereHas('team', function ($q) use ($request) {
                $q->where('id', $request->team);
            });
        }

        // 📌 Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Sorting
        // Allowed sortable columns (VERY IMPORTANT)
        $allowedSorts = [
            'name',
            'email',
            'employee_code',
            'status',
            'created_at'
        ];

        $sortField = in_array($request->sort, $allowedSorts)
            ? $request->sort
            : 'created_at';

        $direction = $request->direction === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortField, $direction);

        return $query->paginate(10)->withQueryString();
    }

    public function getStats()
    {
        return [
            'total' => User::count(),

            'active' => User::where('status', 'active')->count(),

            'inactive' => User::where('status', 'inactive')->count(),

            'assigned' => User::whereNotNull('team_id')->count(),

            'unassigned' => User::whereNull('team_id')->count(),

            'team_leads' => User::whereHas('role', function ($q) {
                $q->where('name', 'team_lead');
            })->count(),
        ];
    }

    public function bulkDelete(array $ids)
    {
        if (empty($ids)) {
            throw ValidationException::withMessages([
                'ids' => 'No employees selected.'
            ]);
        }

        DB::transaction(function () use ($ids) {

            $users = \App\Models\User::whereIn('id', $ids)->get();

            foreach ($users as $user) {

                if ($user->role?->name === 'super_admin') {
                    throw ValidationException::withMessages([
                        'delete' => 'Super Admin cannot be deleted.'
                    ]);
                }

                // Reset team + role before soft delete
                $user->update([
                    'team_id' => null,
                ]);

                $user->delete(); // soft delete
            }
        });
    }

    public function create(array $data)
    {
        $employeeRole = Role::where('name', 'employee')->firstOrFail();
        $data['role_id']=$employeeRole->id;

        if (empty($data['password'])) {
            $data['password'] = "password123";
        }

        $profilePath = null;

        if (request()->hasFile('profile_image')) {
            $profilePath = request()
                ->file('profile_image')
                ->store('employees', 'public');
        }

        return User::create([
            'employee_code' => $data['employee_code'],
            'role_id'=>$data['role_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => $data['status'],
            'team_id' => $data['team_id'] ?? null,
            'profile_image' => $profilePath,
        ]);
    }

    public function update($user, array $data)
    {
    
        $updateData = [
            'employee_code' => $data['employee_code'],
            'name' => $data['name'],
            'email' => $data['email'],
            'status' => $data['status'],
            'team_id' => $data['team_id'] ?? null,
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        if (request()->hasFile('profile_image')) {
            if (
                $user->profile_image &&
                Storage::disk('public')->exists($user->profile_image)
            ) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $updateData['profile_image'] = request()
                ->file('profile_image')
                ->store('employees', 'public');
        }

        $user->update($updateData);

        return $user;
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {

            $user->delete();   // Soft delete only

            DB::commit();

            return true;

        } catch (\Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }
}
