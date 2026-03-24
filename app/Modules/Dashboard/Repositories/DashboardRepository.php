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

    public function adminStats()
    {
        $total = Idea::where('status', '!=', IdeaStatus::Draft)->count();
        $approvedRejectedIdeas = Idea::whereIn('status', [
            IdeaStatus::Approved,
            IdeaStatus::Rejected
        ])->count();
        $approvedIdeas = Idea::where('status', IdeaStatus::Approved)->count();
        $approvalRate = $approvedRejectedIdeas > 0
            ? (($approvedIdeas / $approvedRejectedIdeas) * 100)
            : 0;

        return [
            'total_ideas' => $total,
            'draft' => Idea::where('status', IdeaStatus::Draft)->count(),
            'submitted' => Idea::where('status', IdeaStatus::Submitted)->count(),
            'approved_ideas' => Idea::where('status', IdeaStatus::Approved)->count(),
            'rejected_ideas' => Idea::where('status', IdeaStatus::Rejected)->count(),
            'approval_rate' => $approvalRate

        ];
    }

    public function topContributors()
    {
        return User::select('id', 'name', 'reward_points')
            ->orderByDesc('reward_points')
            ->limit(5)
            ->get();
    }

    public function topTeams()
    {
        return Team::select(
            'teams.id',
            'teams.name',
            DB::raw('SUM(users.reward_points) as total_points')
        )
            ->join('users', 'users.team_id', '=', 'teams.id')
            ->groupBy('teams.id', 'teams.name')
            ->orderByDesc('total_points')
            ->limit(5)
            ->get();
    }

    /* ---------------- TEAM LEAD ---------------- */

    public function teamStats(int $teamId)
    {
        return [
            'total_ideas' => Idea::where('team_id', $teamId)->count(),
            'pending' => Idea::where('team_id', $teamId)
                ->where('status', IdeaStatus::Submitted)->count(),
            'approved' => Idea::where('team_id', $teamId)
                ->where('status', IdeaStatus::Approved)->count(),
            'rejected' => Idea::where('team_id', $teamId)
                ->where('status', IdeaStatus::Rejected)->count(),
        ];
    }

    public function teamLeaderboard(int $teamId)
    {
        return User::where('team_id', $teamId)
            ->select('id', 'name', 'reward_points')
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
    
    public function recentIdeas(int $userId)
    {
        return Idea::where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get(['id', 'title', 'status', 'created_at']);
    }

    public function teamIdeasChart(int $teamId, string $range)
    {
        $startDate = match ($range) {
            '7days'   => now()->subDays(7),
            '30days'  => now()->subDays(30),
            default   => now()->subMonths(6),
        };

        $ideas = Idea::where('team_id', $teamId)
            ->where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(function ($item) use ($range) {
                return match ($range) {
                    '7days', '30days' => $item->created_at->format('d M'),
                    default           => $item->created_at->format('M'),
                };
            });

        return [
            'labels' => $ideas->keys(),
            'data'   => $ideas->map->count()->values(),
        ];
    }

    public function teamRecentIdeas(int $teamId)
    {
        return Idea::where('team_id', $teamId)
            ->latest()
            ->limit(5)
            ->get(['id', 'title', 'status', 'created_at', 'user_id'])
            ->load('user:id,name');
    }

    public function recentIdeasForAdmin()
    {
        return Idea::where('status', '!=' , IdeaStatus::Draft )
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

    public function employeeStats(int $userId)
    {
        $user = User::find($userId);

        return [
            'total_ideas' => Idea::where('user_id', $userId)->count(),
            'pending' => Idea::where('user_id', $userId)
                ->where('status', IdeaStatus::Submitted)->count(),
            'approved' => Idea::where('user_id', $userId)
                ->where('status', IdeaStatus::Approved)->count(),
            'rejected' => Idea::where('user_id', $userId)
                ->where('status', IdeaStatus::Rejected)->count(),
            'reward_points' => $user?->reward_points ?? 0,
        ];
    }
}
