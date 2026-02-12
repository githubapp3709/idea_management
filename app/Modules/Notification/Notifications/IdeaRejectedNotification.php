<?php
namespace App\Modules\Notification\Notifications;

use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class IdeaRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Idea $idea) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'idea_id' => $this->idea->id,
            'title' => $this->idea->title,
            'message' => 'Your idea was rejected',
            'remark' => $this->idea->review_remark,
            'status' => 'rejected',
        ];
    }
}
