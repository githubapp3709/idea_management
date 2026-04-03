<?php

namespace App\Modules\Idea\Repositories;

use App\Models\Idea;
use App\Enums\IdeaStatus;

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

        // $query->where(function ($q) use ($user) {
        //     $q->where('status', '!=', 'draft')
        //         ->orWhere('user_id', $user->id);
        // });

        $query->where(function ($q) use ($user) {

            // Public ideas (exclude draft & feedback)
            $q->whereNotIn('status', ['draft', 'feedback'])
                // OR own ideas (can see everything)
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

        /* ================= ROLE FILTER ================= */

        if ($user->role->name === 'employee') {
            $query->where('user_id', $user->id);
        }

        if ($user->role->name === 'team_lead') {
            $query->where('team_id', $user->team_id);
        }

        // ✅ IMPORTANT: Draft visibility control
        $query->where(function ($q) use ($user) {
            $q->where('status', '!=', 'draft') // all non-draft
                ->orWhere(function ($q2) use ($user) {
                    $q2->where('status', 'draft')
                        ->where('user_id', $user->id); // only own drafts
                });
        });

        return [
            'total'     => (clone $query)->count(),

            // Draft must ALWAYS be own only
            'draft'     => Idea::where('status', 'draft')
                ->where('user_id', $user->id)
                ->count(),

            'submitted' => (clone $query)->where('status', 'submitted')->count(),
            'approved'  => (clone $query)->where('status', 'approved')->count(),
            'rejected'  => (clone $query)->where('status', 'rejected')->count(),
        ];
    }

    public function approvedIdeas($request)
    {
        return Idea::with('user:id,name')

            ->where('status', \App\Enums\IdeaStatus::Approved)

            // 🔍 SEARCH
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhereHas('user', function ($q2) use ($search) {
                            $q2->where('name', 'like', "%$search%");
                        });
                });
            })

            // 📅 FROM DATE
            ->when($request->from_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);
            })

            // 📅 TO DATE
            ->when($request->to_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();
    }
}
