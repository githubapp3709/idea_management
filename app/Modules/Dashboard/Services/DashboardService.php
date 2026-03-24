<?php

namespace App\Modules\Dashboard\Services;

use App\Modules\Dashboard\Repositories\DashboardRepository;
use App\Models\User;

class DashboardService
{
    public function __construct(
        protected DashboardRepository $repo
    ) {}

    /* ================= ADMIN ================= */

    public function admin()
    {
        return [
            'stats' => $this->repo->adminStats(),
            'employee_stats' => $this->repo->employeeStatsAll(),
            'recent_ideas' => $this->repo->recentIdeasForAdmin(),
            'top_contributors' => $this->repo->topContributors(),
            'top_teams' => $this->repo->topTeams(),
            'teams' => $this->repo->teamCards(),
        ];
    }

    /* ================= TEAM LEAD ================= */

    public function teamLead(User $user, string $range = '6months')
    {
        return [
            'stats' => $this->repo->teamStats($user->team_id),
            'team_members' => $this->repo->teamLeaderboard($user->team_id),
            'chart' => $this->repo->teamIdeasChart($user->team_id, $range),
            'recent_ideas' => $this->repo->teamRecentIdeas($user->team_id),
        ];
    }

    /* ================= EMPLOYEE ================= */

    public function employee(User $user)
    {
        return [
            'stats' => $this->repo->employeeStats($user->id),
            'recent_ideas' => $this->repo->recentIdeas($user->id),
        ];
    }
}