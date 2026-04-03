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

        $topContributors = User::whereHas('ideas', function ($q) use ($request) {
            $this->applyDateFilter($q, $request);
        })
            ->select('id', 'name', 'reward_points')
            ->orderByDesc('reward_points')
            ->take(5)
            ->get();

        /* ================= TOP TEAMS ================= */

        $topTeams = Team::withSum([
            'users as total_points' => function ($q) use ($request) {
                $this->applyDateFilter($q, $request);
            }
        ], 'reward_points')
            ->orderByDesc('total_points')
            ->take(5)
            ->get();

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

    public function teamLeaderboard(int $teamId)
    {
        return User::where('team_id', $teamId)
            ->select('id', 'name', 'reward_points')
            ->withCount([
                'ideas as total_ideas' => function ($q) {
                    $q->whereIn('status', ['submitted', 'approved', 'rejected']);
                }
            ])
            ->orderByDesc('reward_points')
            ->get();
    }

    /* ---------------- EMPLOYEE ---------------- */

    public function employeeStatsAll()
    {
        return [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'assigned' => User::whereNotNull('team_id')->count(),
            'unassigned' => User::whereNull('team_id')->count(),
            'team_leads' => User::whereHas('role', fn($q) => $q->where('name', 'team_lead'))->count(),
        ];
    }

    public function recentIdeas(int $userId, $request)
    {
        $query = Idea::where('user_id', $userId);

        $query = $this->applyDateFilter($query, $request);

        return $query->latest()
            ->limit(5)
            ->get(['id', 'title', 'status', 'created_at']);
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

    public function employeeIdeasChart(int $userId, $request)
    {
        $user= User::find($userId);
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


    public function teamRecentIdeas(int $teamId, $request)
    {
        $query = Idea::where('team_id', $teamId);

        $query = $this->applyDateFilter($query, $request);

        return $query->latest()
            ->limit(5)
            ->get(['id', 'title', 'status', 'created_at', 'user_id'])
            ->load('user:id,name');
    }

    public function recentIdeasForAdmin()
    {
        return Idea::where('status', '!=', IdeaStatus::Draft)
            ->latest()
            ->limit(5)
            ->get();
    }

    public function teamCards()
    {
        return Team::withCount([
            'ideas',
            'ideas as approved_ideas_count' => function ($q) {
                $q->where('status', IdeaStatus::Approved);
            }
        ])->get();
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
            'reward_points' => $user?->reward_points ?? 0,
        ];
    }

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
