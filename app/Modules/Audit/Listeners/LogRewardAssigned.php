<?php

namespace App\Modules\Audit\Listeners;

use App\Modules\Reward\Jobs\AssignIdeaRewardJob;
use App\Modules\Audit\Services\AuditService;

class LogRewardAssigned
{
    public function handle($event)
    {
        app(AuditService::class)->log(
            action: 'reward_assigned',
            model: 'IdeaReward',
            modelId: $event->idea->id,
            newValues: ['points' => $event->points],
            remark: 'Reward assigned on approval'
        );
    }
}
