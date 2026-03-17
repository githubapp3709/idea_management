<?php

namespace App\Modules\Idea\Repositories;

use App\Models\Idea;

class IdeaRepository
{
    public function create(array $data)
    {
        return Idea::create($data);
    }

    public function update(Idea $idea, array $data): Idea
    {
        $idea->update($data);

        return $idea;
    }

    public function delete(Idea $idea): void
    {
        $idea->delete(); // Soft delete if trait used
    }
}
