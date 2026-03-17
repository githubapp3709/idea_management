<?php

namespace App\Modules\Team\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Team;
use App\Modules\Team\Repositories\TeamRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                $team = new Team();
            }

            $team->name = $data['name'];
            $team->team_lead_id = $data['leader_id'] ?? null;

            // 🔥 Handle image upload
            if (request()->hasFile('image')) {

                // Delete old image if exists
                if ($team->image && Storage::disk('public')->exists($team->image)) {
                    Storage::disk('public')->delete($team->image);
                }

                $path = request()->file('image')
                    ->store('teams', 'public');

                $team->image = $path;
            }

            $team->save();
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
