<?php

namespace App\Modules\Dashboard\Repositories;

use App\Models\Idea;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    /* ---------------- ADMIN ---------------- */

    public function adminStats()
    {
        return [
            'total_ideas' => Idea::count(),
            'approved_ideas' => Idea::where('status', 'approved')->count(),
            'rejected_ideas' => Idea::where('status', 'rejected')->count(),
            'pending_ideas' => Idea::whereIn('status', ['submitted'])->count(),
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
                             ->where('status', 'submitted')
                             ->count(),
            'approved' => Idea::where('team_id', $teamId)
                              ->where('status', 'approved')
                              ->count(),
            'rejected' => Idea::where('team_id', $teamId)
                              ->where('status', 'rejected')
                              ->count(),
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

    public function employeeStats(int $userId)
    {
        return [
            'total_ideas' => Idea::where('user_id', $userId)->count(),
            'pending' => Idea::where('user_id', $userId)
                             ->where('status', 'submitted')
                             ->count(),
            'approved' => Idea::where('user_id', $userId)
                              ->where('status', 'approved')
                              ->count(),
            'rejected' => Idea::where('user_id', $userId)
                              ->where('status', 'rejected')
                              ->count(),
            'reward_points' => User::find($userId)->reward_points,
        ];
    }

    public function recentIdeas(int $userId)
    {
        return Idea::where('user_id', $userId)
            ->latest()
            ->limit(5)
            ->get(['id', 'title', 'status', 'created_at']);
    }
}
