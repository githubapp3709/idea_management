<?php

namespace App\Modules\Team\Repositories;

use App\Models\Team; 

class TeamRepository
{ 
    public function create(array $data)
    {
        return Team::create($data);
    }

    public function update(Team $team, array $data)
    {
        $team->update($data);
        return $team;
    }

    public function assignUserToTeam($user, Team $team)
    {
        $user->update(['team_id' => $team->id]);
    }
}
