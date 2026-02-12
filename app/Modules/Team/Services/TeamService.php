<?php

namespace App\Modules\Team\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Team;
use App\Modules\Team\Repositories\TeamRepository;
use Illuminate\Support\Facades\DB;

class TeamService
{
    public function __construct(
        protected TeamRepository $teamRepo
    ) {}

   
    
    public function delete(Team $team)
    {
        // Remove team from users
        User::where('team_id', $team->id)
            ->update(['team_id' => null]);

        // Delete team
        $team->delete();
    }


    public function saveTeamWithMembers(?Team $team, array $data, array $memberIds)
    {
        return DB::transaction(function () use ($team, $data, $memberIds) {

            $employeeRole = Role::where('name', 'employee')->firstOrFail();
            $teamLeadRole = Role::where('name', 'team_lead')->firstOrFail();

            // 1️⃣ Create or update team
            if (!$team) {
                $team = Team::create([
                    'name' => $data['name'],
                    'team_lead_id' => $data['leader_id'] ?? null,
                ]);
            } else {
                $team->update([
                    'name' => $data['name'],
                    'team_lead_id' => $data['leader_id'] ?? null,
                ]);
            }

            $team->refresh();

            // 2️⃣ Reset existing team members (only if updating)
            User::where('team_id', $team->id)
                ->update([
                    'team_id' => null,
                    'role_id' => $employeeRole->id,
                ]);

            // 3️⃣ Assign selected members
            if (!empty($memberIds)) {
                User::whereIn('id', $memberIds)
                    ->update(['team_id' => $team->id]);
            }

            // 4️⃣ Assign team lead role
            if ($team->team_lead_id) {
                User::where('id', $team->team_lead_id)
                    ->update([
                        'role_id' => $teamLeadRole->id,
                        'team_id' => $team->id,
                    ]);
            }

            return $team;
        });
    }
}
