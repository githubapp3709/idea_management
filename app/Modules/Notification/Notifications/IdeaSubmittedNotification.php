<?php
namespace App\Modules\Notification\Notifications;

use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class IdeaSubmittedNotification extends Notification
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
            'message' => 'New idea submitted for review',
            'submitted_by' => $this->idea->user->name,
        ];
    }
}
