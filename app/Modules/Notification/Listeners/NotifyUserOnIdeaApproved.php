<?php

namespace App\Modules\Notification\Listeners;

use App\Modules\Idea\Events\IdeaApproved;
use App\Modules\Notification\Notifications\IdeaApprovedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUserOnIdeaApproved
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(IdeaApproved $event): void
    {
       
        $event->idea->user->notify(
            new IdeaApprovedNotification($event->idea)
        );
    }
}
