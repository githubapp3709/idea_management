<?php

namespace App\Modules\Team\Services;

use App\Models\User;
use App\Models\Team;
use App\Modules\Team\Repositories\TeamRepository;
use Illuminate\Support\Facades\DB;

class TeamService
{
    public function __construct(
        protected TeamRepository $teamRepo
    ) {}

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $team = $this->teamRepo->create($data);

            if (!empty($data['team_lead_id'])) {
                $this->assignLeader($team, $data['team_lead_id']);
            }

            return $team;
        });
    }

    public function assignLeader(Team $team, int $leaderId)
    {
        $leader = User::findOrFail($leaderId);

        if ($leader->role->name !== 'team_lead') {
            throw new \Exception('User is not a Team Lead');
        }

        $team->update(['team_lead_id' => $leader->id]);
        $leader->update(['team_id' => $team->id]);
    }

    public function addUserToTeam(User $user, Team $team)
    {
        if ($user->team_id) {
            throw new \Exception('User already belongs to a team');
        }

        $user->update(['team_id' => $team->id]);
    }

    public function update(Team $team, array $data)
    {
        return $this->teamRepo->update($team, $data);
    }

    public function assignMembers(Team $team, array $memberIds)
    {
        // Remove existing members of this team
        User::where('team_id', $team->id)
            ->update(['team_id' => null]);

        // Assign selected members
        if (!empty($memberIds)) {
            User::whereIn('id', $memberIds)
                ->update(['team_id' => $team->id]);
        }
    }
    public function delete(Team $team)
    {
        // Remove team from users
        User::where('team_id', $team->id)
            ->update(['team_id' => null]);

        // Delete team
        $team->delete();
    }
}
