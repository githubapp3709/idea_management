<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [

        \App\Modules\Idea\Events\IdeaApproved::class => [
            \App\Modules\Reward\Listeners\AssignRewardOnIdeaApproved::class,
            \App\Modules\Notification\Listeners\NotifyUserOnIdeaApproved::class,
            \App\Modules\Audit\Listeners\LogIdeaApproved::class,
        ],

        \App\Modules\Idea\Events\IdeaRejected::class => [
            \App\Modules\Notification\Listeners\NotifyUserOnIdeaRejected::class,
            \App\Modules\Audit\Listeners\LogIdeaRejected::class,
        ],
        \App\Modules\Idea\Events\IdeaSubmitted::class => [
            \App\Modules\Notification\Listeners\NotifyTeamLeadOnIdeaSubmitted::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();

        \Log::info('EventServiceProvider booted');
    }
}
