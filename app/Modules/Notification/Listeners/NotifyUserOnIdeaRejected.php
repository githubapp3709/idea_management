<?php

namespace App\Modules\Notification\Listeners;

use App\Modules\Idea\Events\IdeaRejected;
use App\Modules\Notification\Notifications\IdeaRejectedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUserOnIdeaRejected
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
    public function handle(IdeaRejected $event): void
    {
        $event->idea->user->notify(
            new IdeaRejectedNotification($event->idea)
        );
    }
}
