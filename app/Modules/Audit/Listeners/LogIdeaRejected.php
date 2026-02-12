<?php

namespace App\Modules\Audit\Listeners;

use App\Modules\Idea\Events\IdeaRejected;
use App\Modules\Audit\Services\AuditService;

class LogIdeaRejected
{
    public function handle(IdeaRejected $event)
    {
        app(AuditService::class)->log(
            action: 'idea_rejected',
            model: 'Idea',
            modelId: $event->idea->id,
            oldValues: ['status' => 'submitted'],
            newValues: ['status' => 'rejected'],
            remark: $event->idea->review_remark
        );
    }
}
