<?php

namespace App\Modules\Dashboard\Repositories;

use App\Models\Idea;
use App\Models\User;
use App\Models\Team;
use App\Enums\IdeaStatus;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    /* ---------------- ADMIN ---------------- */

    public function getAdminDashboardData($request)
    {
        /* ================= BASE QUERY ================= */

        $base = Idea::query();
        $base = $this->applyDateFilter($base, $request);

        /* ================= STATS ================= */

        $stats = [
            'total_ideas' => (clone $base)->whereIn('status', ['approved', 'submitted', 'rejected'])->count(),
            'total_ideas_for_approval_rate' => (clone $base)->whereIn('status', ['approved', 'rejected'])->count(),
            'submitted' => (clone $base)->where('status', 'submitted')->count(),
            'approved_ideas' => (clone $base)->where('status', 'approved')->count(),
            'rejected_ideas' => (clone $base)->where('status', 'rejected')->count(),
        ];

        $stats['approval_rate'] = $stats['total_ideas_for_approval_rate'] > 0
            ? round(($stats['approved_ideas'] / $stats['total_ideas_for_approval_rate']) * 100)
            : 0;

        /* ================= RECENT IDEAS ================= */

        $recentIdeas = (clone $base)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        /* ================= TOP CONTRIBUTORS ================= */

        $topContributors = User::with([
            'team:id,name',
            'ideas.rewards' => function ($q) use ($request) {
                $this->applyDateFilter($q, $request); // ✅ NOW USING COMMON FILTER
            }
        ])
            ->get()
            ->map(function ($user) {

                $total = $user->ideas->sum(function ($idea) {
                    return $idea->rewards->sum('points');
                });

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'team_name' => $user->team?->name ?? 'No Team',
                    'reward_points' => $total,
                ];
            })
            ->filter(fn($u) => $u['reward_points'] > 0) // optional
            ->sortByDesc('reward_points')
            ->take(5)
            ->values();

        /* ================= TOP TEAMS ================= */

        $topTeams = Team::with([
            'users.ideas.rewards' => function ($q) use ($request) {
                $this->applyDateFilter($q, $request); // ✅ CORRECT
            }
        ])
            ->get()
            ->map(function ($team) {

                $total = $team->users->sum(function ($user) {
                    return $user->ideas->sum(function ($idea) {
                        return $idea->rewards->sum('points');
                    });
                });

                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'reward_points' => $total,
                ];
            })
            ->filter(fn($t) => $t['reward_points'] > 0)
            ->sortByDesc('reward_points')
            ->take(5)
            ->values();

        /* ================= TEAM CARDS ================= */

        $teams = Team::withCount([
            'ideas' => function ($q) use ($request) {
                $this->applyDateFilter($q, $request);
            },
            'ideas as approved_ideas_count' => function ($q) use ($request) {
                $q->where('status', 'approved');
                $this->applyDateFilter($q, $request);
            }
        ])->get();

        /* ================= EMPLOYEE STATS (FILTERED) ================= */

        $baseUser = User::query();
        $baseUser = $this->applyDateFilter($baseUser, $request);
        $employeeStats = [
            'total' => (clone $baseUser)->count(),

            'active' => (clone $baseUser)
                ->where('status', 'active')
                ->count(),

            'inactive' => (clone $baseUser)
                ->where('status', 'inactive')
                ->count(),

            'assigned' => (clone $baseUser)
                ->whereNotNull('team_id')
                ->count(),

            'unassigned' => (clone $baseUser)
                ->whereNull('team_id')
                ->count(),

            'team_leads' => (clone $baseUser)
                ->whereHas(
                    'role',
                    fn($q) =>
                    $q->where('name', 'team_lead')
                )->count(),
        ];

        return [
            'stats' => $stats,
            'employee_stats' => $employeeStats,
            'recent_ideas' => $recentIdeas,
            'top_contributors' => $topContributors,
            'top_teams' => $topTeams,
            'teams' => $teams,
        ];
    }

    /* ---------------- TEAM LEAD ---------------- */

    public function teamStats(int $teamId, $request)
    {
        $base = Idea::where('team_id', $teamId);

        $base = $this->applyDateFilter($base, $request);

        return [
            'total_ideas' => (clone $base)->whereIn('status', ['submitted', 'approved', 'rejected'])->count(),
            'pending' => (clone $base)->where('status', IdeaStatus::Submitted)->count(),
            'approved' => (clone $base)->where('status', IdeaStatus::Approved)->count(),
            'rejected' => (clone $base)->where('status', IdeaStatus::Rejected)->count(),
        ];
    }


    public function teamLeaderboard(int $teamId, $request)
    {
        return User::where('team_id', $teamId)
            ->with([
                'ideas' => function ($q) use ($request) {
                    $q->whereIn('status', ['submitted', 'approved', 'rejected']);
                    $this->applyDateFilter($q, $request); // ✅ filter ideas
                },
                'ideas.rewards' => function ($q) use ($request) {
                    $this->applyDateFilter($q, $request); // ✅ filter rewards
                }
            ])
            ->withCount([
                'ideas as total_ideas' => function ($q) use ($request) {
                    $q->whereIn('status', ['submitted', 'approved', 'rejected']);
                    $this->applyDateFilter($q, $request); // ✅ SAME filter on ideas
                }
            ])
            ->get()
            ->map(function ($user) {

                $totalPoints = $user->ideas->sum(function ($idea) {
                    return $idea->rewards->sum('points');
                });

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'total_ideas' => $user->total_ideas,
                    'total_points' => $totalPoints,
                ];
            })
            ->sortByDesc('total_points')
            ->values();
    }

    public function teamIdeasChart(int $teamId, $request)
    {
        $query = Idea::where('team_id', $teamId);

        $query = $this->applyDateFilter($query, $request);

        $ideas = $query->get()->groupBy(function ($item) {
            return $item->created_at->format('d M');
        });

        return [
            'labels' => $ideas->keys(),
            'data'   => $ideas->map->count()->values(),
        ];
    }

    public function teamRecentIdeas(int $teamId, $request)
    {

        $query = Idea::where('team_id', $teamId)
            ->where('status', '!=', IdeaStatus::Draft);

        $query = $this->applyDateFilter($query, $request);

        return $query->latest()
            ->limit(5)
            ->get(['id', 'title', 'status', 'created_at', 'user_id'])
            ->load('user:id,name');
    }


    /* ---------------- EMPLOYEE ---------------- */

    public function recentIdeas(int $userId, $request)
    {
        $query = Idea::where('user_id', $userId);

        $query = $this->applyDateFilter($query, $request);

        return $query->latest()
            ->limit(5)
            ->get(['id', 'title', 'status', 'created_at']);
    }


    public function employeeIdeasChart(int $userId, $request)
    {
        $user = User::find($userId);
        $query = Idea::where('team_id', $user->team_id);

        $query = $this->applyDateFilter($query, $request);

        $ideas = $query->get()->groupBy(function ($item) {
            return $item->created_at->format('d M');
        });

        return [
            'labels' => $ideas->keys(),
            'data'   => $ideas->map->count()->values(),
        ];
    }


    public function employeeStats(int $userId, $request)
    {
        $base = Idea::where('user_id', $userId);

        $base = $this->applyDateFilter($base, $request);

        $user = User::find($userId);

        return [
            'total_ideas' => (clone $base)->count(),
            'drafts' => (clone $base)->where('status', IdeaStatus::Draft)->count(),
            'pending' => (clone $base)->where('status', IdeaStatus::Submitted)->count(),
            'approved' => (clone $base)->where('status', IdeaStatus::Approved)->count(),
            'rejected' => (clone $base)->where('status', IdeaStatus::Rejected)->count(),
            'reward_points' => Idea::where('user_id', $userId)
                ->whereHas('rewards', function ($q) use ($request) {
                    $this->applyDateFilter($q, $request);
                })
                ->with(['rewards' => function ($q) use ($request) {
                    $this->applyDateFilter($q, $request);
                }])
                ->get()
                ->sum(function ($idea) {
                    return $idea->rewards->sum('points');
                }),
        ];
    }


    //----------------- date filter common function-----------------

    private function applyDateFilter($query, $request)
    {
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        return $query;
    }
}
