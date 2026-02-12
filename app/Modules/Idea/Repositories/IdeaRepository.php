<?php

namespace App\Modules\Idea\Repositories;

use App\Models\Idea;

class IdeaRepository
{
    public function create(array $data)
    {
        return Idea::create($data);
    }

    public function update(Idea $idea, array $data)
    {
        $idea->update($data);
        return $idea;
    }
}
