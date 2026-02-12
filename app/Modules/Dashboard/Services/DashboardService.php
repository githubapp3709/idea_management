<?php
namespace App\Modules\Dashboard\Services;

use App\Modules\Dashboard\Repositories\DashboardRepository;
use App\Models\User;

class DashboardService
{
    public function __construct(
        protected DashboardRepository $repo
    ) {}

    public function admin()
    {      
        return [
            'stats' => $this->repo->adminStats(),
            'top_contributors' => $this->repo->topContributors(),
            'top_teams' => $this->repo->topTeams(),
        ];
    }

    public function teamLead(User $user)
    {
        
        return [
            'stats' => $this->repo->teamStats($user->team_id),
            'team_members' => $this->repo->teamLeaderboard($user->team_id),
        ];
    }

    public function employee(User $user)
    {
        return [
            'stats' => $this->repo->employeeStats($user->id),
            'recent_ideas' => $this->repo->recentIdeas($user->id),
        ];
    }
}
