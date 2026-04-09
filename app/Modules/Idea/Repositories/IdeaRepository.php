<?php

namespace App\Modules\Idea\Repositories;

use App\Models\Idea;
use App\Enums\IdeaStatus;
use Illuminate\Support\Facades\Auth;

class IdeaRepository
{

    public function getFilteredIdeas($request)
    {
        $user = Auth::user();

        $query = Idea::with('user');

        // ================= ROLE BASED =================

        if ($user->role->name === 'employee') {

            // Only own ideas
            $query->where('user_id', $user->id);
        } elseif ($user->role->name === 'team_lead') {

            $query->where(function ($q) use ($user) {

                // Own ideas (include draft)
                $q->where('user_id', $user->id)

                    // Team ideas (exclude draft)
                    ->orWhere(function ($q2) use ($user) {
                        $q2->where('team_id', $user->team_id)
                            ->where('ideas.status', '!=', IdeaStatus::Draft);
                    });
            });
        } else { // super_admin

            $query->where(function ($q) use ($user) {

                // Own ideas (include draft)
                $q->where('user_id', $user->id)

                    // Others (exclude draft)
                    ->orWhere(function ($q2) use ($user) {
                        $q2->where('user_id', '!=', $user->id)
                            ->where('ideas.status', '!=', IdeaStatus::Draft);
                    });
            });
        }

        // ================= SEARCH =================

        $query->when($request->search, function ($q) use ($request) {
            $search = $request->search;

            $q->where(function ($q2) use ($search) {
                $q2->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereHas('user', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%$search%");
                    });
            });
        });

        // ================= STATUS =================

        $query->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        // ================= DATE =================

        $query->when($request->from_date, function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->from_date);
        });

        $query->when($request->to_date, function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->to_date);
        });

        // ================= SORT =================

        $query->when($request->sort, function ($q) use ($request) {

            $direction = $request->direction ?? 'desc';

            match ($request->sort) {
                'title' => $q->orderBy('title', $direction),
                'status' => $q->orderBy('status', $direction),
                'date' => $q->orderBy('created_at', $direction),
                'user' => $q->join('users', 'users.id', '=', 'ideas.user_id')
                    ->orderBy('users.name', $direction)
                    ->select('ideas.*'),
                default => $q->latest(),
            };
        }, fn($q) => $q->latest());

        return $query->paginate(10)->withQueryString();
    }

    public function filteredStatsFromQuery($query)
    {
        return [
            'total' => (clone $query)->count(),

            'draft' => (clone $query)->where('ideas.status', IdeaStatus::Draft)->count(),

            'submitted' => (clone $query)->where('ideas.status', IdeaStatus::Submitted)->count(),

            'approved' => (clone $query)->where('ideas.status', IdeaStatus::Approved)->count(),

            'rejected' => (clone $query)->where('ideas.status', IdeaStatus::Rejected)->count(),
        ];
    }


    public function baseQuery($request)
    {
        $user = Auth::user();

        $query = Idea::query()->with('user');

        // ================= ROLE BASED =================

        if ($user->role->name === 'employee') {

            $query->where('user_id', $user->id);
        } elseif ($user->role->name === 'team_lead') {

            $query->where(function ($q) use ($user) {

                $q->where('ideas.user_id', $user->id)

                    ->orWhere(function ($q2) use ($user) {
                        $q2->where('ideas.team_id', $user->team_id)
                            ->where('ideas.status', '!=', IdeaStatus::Draft);
                    });
            });
        } else {
            // super_admin
            $query->where(function ($q) use ($user) {

                $q->where('ideas.user_id', $user->id)

                    ->orWhere(function ($q2) use ($user) {
                        $q2->where('user_id', '!=', $user->id)
                            ->where('ideas.status', '!=', IdeaStatus::Draft);
                    });
            });
        }

        // ================= SEARCH =================

        $query->when($request->search, function ($q) use ($request) {
            $search = $request->search;

            $q->where(function ($q2) use ($search) {
                $q2->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereHas('user', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%$search%");
                    });
            });
        });

        // ================= STATUS =================

        $query->when($request->status, function ($q) use ($request) {
            $q->where('ideas.status', $request->status);
        });

        // ================= DATE =================

        $query->when($request->from_date, function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->from_date);
        });

        $query->when($request->to_date, function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->to_date);
        });

        // ================= SORT =================

        $query->when($request->sort, function ($q) use ($request) {

            $direction = $request->direction ?? 'desc';

            match ($request->sort) {
                'title' => $q->orderBy('title', $direction),
                'status' => $q->orderBy('status', $direction),
                'date' => $q->orderBy('created_at', $direction),
                'user' => $q->join('users', 'users.id', '=', 'ideas.user_id')
                    ->orderBy('users.name', $direction)
                    ->select('ideas.*'),
                default => $q->latest(),
            };
        }, fn($q) => $q->latest());

        return $query;
    }


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

        // IMPORTANT: Draft visibility control
        $query->where(function ($q) use ($user) {
            $q->where('ideas.status', '!=', 'draft') // all non-draft
                ->orWhere(function ($q2) use ($user) {
                    $q2->where('ideas.status', 'draft')
                        ->where('user_id', $user->id); // only own drafts
                });
        });

        return [
            'total'     => (clone $query)->count(),

            // Draft must ALWAYS be own only
            'draft'     => Idea::where('ideas.status', 'draft')
                ->where('user_id', $user->id)
                ->count(),

            'submitted' => (clone $query)->where('ideas.status', 'submitted')->count(),
            'approved'  => (clone $query)->where('ideas.status', 'approved')->count(),
            'rejected'  => (clone $query)->where('ideas.status', 'rejected')->count(),
        ];
    }

    public function approvedIdeas($request)
    {
        return Idea::with('user:id,name')

            ->where('ideas.status', IdeaStatus::Approved)

            // SEARCH
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

            // FROM DATE
            ->when($request->from_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->from_date);
            })

            // TO DATE
            ->when($request->to_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->to_date);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();
    }
}
