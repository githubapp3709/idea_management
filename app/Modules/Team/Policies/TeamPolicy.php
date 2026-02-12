<?php

namespace App\Modules\Team\Policies;

use App\Models\User;
use App\Models\Team;

class TeamPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->name === 'super_admin';
    }

    public function view(User $user, Team $team): bool
    {
        return $user->role->name === 'super_admin';
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'super_admin';
    }

    public function update(User $user, Team $team): bool
    {
        return $user->role->name === 'super_admin';
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->role->name === 'super_admin';
    }
}
