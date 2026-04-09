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

    public function admin($request)
    {
        return $this->repo->getAdminDashboardData($request);
    } 

    /* ================= TEAM LEAD ================= */

    public function teamLead(User $user, $request)
    {
        return [
            'stats' => $this->repo->teamStats($user->team_id, $request),
            'team_members' => $this->repo->teamLeaderboard($user->team_id, $request),
            'chart' => $this->repo->teamIdeasChart($user->team_id, $request),
            'recent_ideas' => $this->repo->teamRecentIdeas($user->team_id, $request),
        ];
    }

    /* ================= EMPLOYEE ================= */

    public function employee(User $user, $request)
    {
        return [
            'stats' => $this->repo->employeeStats($user->id, $request),
            'chart' => $this->repo->employeeIdeasChart($user->id, $request),
            'recent_ideas' => $this->repo->recentIdeas($user->id, $request),
        ];
    } 
}
