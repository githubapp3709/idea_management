<?php

namespace App\Modules\Audit\Listeners;

use App\Modules\Idea\Events\IdeaApproved;
use App\Modules\Audit\Services\AuditService;

class LogIdeaApproved
{
    public function handle(IdeaApproved $event)
    {
        app(AuditService::class)->log(
            action: 'idea_approved',
            model: 'Idea',
            modelId: $event->idea->id,
            oldValues: ['status' => 'submitted'],
            newValues: ['status' => 'approved'],
            remark: $event->idea->review_remark
        );
    }
}
