<?php

namespace App\Modules\Employee\Policies;


use app\Models\User;

class EmployeesPolicy
{
    public function viewAny(User $user): bool
    {
    
        return $user->role->name === 'super_admin';
    }

    public function view(User $user): bool
    {
        return $user->role->name === 'super_admin';
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'super_admin';
    }

    public function update(User $user): bool
    {
        return $user->role->name === 'super_admin';
    }

    public function delete(User $user): bool
    {
        return $user->role->name === 'super_admin';
    }
}