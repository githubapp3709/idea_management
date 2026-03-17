<?php

namespace App\Modules\Idea\Policies;

use App\Enums\IdeaStatus;
use app\Models\Idea;
use app\Models\User;

class IdeaPolicy
{
    public function update(User $user, Idea $idea)
    {

        return $user->id === $idea->user_id
            && $idea->status === IdeaStatus::Draft;
    }

    public function submit(User $user, Idea $idea)
    {
        return $user->id === $idea->user_id
            && $idea->status === IdeaStatus::Draft;
    }

    public function review(User $user, Idea $idea)
    {
        if ($idea->status !== IdeaStatus::Submitted) {
            return false;
        }

        // Super Admin can review anything
        if ($user->role->name === 'super_admin') {
            return true;
        }

        // Team Lead can review only team ideas
        return $user->role->name === 'team_lead'
            && $user->team_id === $idea->team_id;
    }

    public function view(User $user, Idea $idea)
    {
        // 🚫 Draft ideas are PRIVATE
        // Only owner can see them (no exception)
        if ($idea->status === IdeaStatus::Draft) {
            return $idea->user_id === $user->id;
        }

        // ✅ Non-draft ideas follow role-based visibility

        // Employee → only own ideas
        if ($user->role->name === 'employee') {
            return $idea->user_id === $user->id;
        }

        // Team Lead → ideas of their team
        if ($user->role->name === 'team_lead') {
            return $idea->team_id === $user->team_id;
        }

        // Super Admin → everything except drafts
        if ($user->role->name === 'super_admin') {
            return true;
        }

        return false;
    }

    public function delete(User $user, Idea $idea)
    {
        return $user->id === $idea->user_id;
    }
}
