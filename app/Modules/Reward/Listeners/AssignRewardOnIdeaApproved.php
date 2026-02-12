<?php

namespace App\Modules\Reward\Listeners;


use App\Modules\Idea\Events\IdeaApproved;
use App\Modules\Reward\Jobs\AssignIdeaRewardJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignRewardOnIdeaApproved
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(IdeaApproved $event)
    {
        AssignIdeaRewardJob::dispatch($event->idea);
    }
}
