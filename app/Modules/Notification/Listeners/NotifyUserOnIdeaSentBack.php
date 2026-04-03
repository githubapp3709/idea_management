<?php

namespace App\Modules\Notification\Listeners;

use App\Modules\Idea\Events\IdeaRejected;
use App\Modules\Notification\Notifications\IdeaSentBackNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUserOnIdeaSentBack
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
        \Log::info('SendBack Listener triggered', [
            'idea_id' => $event->idea->id,
        ]);

        $event->idea->user->notify(
            new IdeaSentBackNotification($event->idea)
        );
    }
}
