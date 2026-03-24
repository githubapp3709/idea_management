<?php

namespace App\Modules\Idea\Repositories;

use App\Models\Idea;

class IdeaRepository
{
    public function create(array $data)
    {
        return Idea::create($data);
    }

    public function update(Idea $idea, array $data): Idea
    {
        $idea->update($data);

        return $idea;
    }

    public function delete(Idea $idea): void
    {
        $idea->delete(); // Soft delete if trait used
    }

    public function getFilteredIdeas($request, $user)
{
    $query = Idea::with('user');

    /* ================= ROLE FILTER ================= */

    $query->where(function ($q) use ($user) {
        $q->where('status', '!=', 'draft')
          ->orWhere('user_id', $user->id);
    });

    if ($user->role->name === 'employee') {
        $query->where('user_id', $user->id);
    }

    if ($user->role->name === 'team_lead') {
        $query->where('team_id', $user->team_id);
    }

    /* ================= STATUS FILTER ================= */

    if ($request->status) {
        $query->where('status', $request->status);
    }

    /* ================= SEARCH FILTER ================= */

    if ($request->search) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('title', 'like', "%$search%")
              ->orWhere('description', 'like', "%$search%")
              ->orWhereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
              });

        });
    }

    return $query->latest()->paginate(10)->withQueryString();
}

public function getStats($user)
{
    $query = Idea::query();

    // Apply role filter ONLY (no search/status)
    if ($user->role->name === 'employee') {
        $query->where('user_id', $user->id);
    }

    if ($user->role->name === 'team_lead') {
        $query->where('team_id', $user->team_id);
    }

    return [
        'total'     => (clone $query)->count(),
        'draft'     => (clone $query)->where('status', 'draft')->count(),
        'submitted' => (clone $query)->where('status', 'submitted')->count(),
        'approved'  => (clone $query)->where('status', 'approved')->count(),
        'rejected'  => (clone $query)->where('status', 'rejected')->count(),
    ];
}
}
