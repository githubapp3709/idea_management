<?php

namespace App\Modules\Notification\Listeners;

use App\Modules\Idea\Events\IdeaSubmitted;
use App\Modules\Notification\Notifications\IdeaSubmittedNotification;
use App\Models\User;

class NotifyTeamLeadOnIdeaSubmitted
{
    public function handle(IdeaSubmitted $event): void
    {
        \Log::info('NotifyTeamLeadOnIdeaSubmitted triggered');

        $idea = $event->idea;

        // Find team lead of that team
        $teamLead = User::where('team_id', $idea->team_id)
            ->whereHas('role', function ($q) {
                $q->where('name', 'team_lead');
            })
            ->first();

        if ($teamLead) {
            $teamLead->notify(
                new IdeaSubmittedNotification($idea)
            );
        }
    }
}
