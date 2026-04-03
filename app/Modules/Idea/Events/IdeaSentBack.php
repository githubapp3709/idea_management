<?php

namespace App\Modules\Idea\Events;

use App\Models\Idea;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IdeaSentBack
{
    use Dispatchable, SerializesModels;

    public function __construct(public Idea $idea)
    {
        \Log::info('IdeaSentBack event fired', [
            'idea_id' => $idea->id,
        ]);
    }
}