<?php

namespace App\Modules\Notification\Notifications;

use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class IdeaRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public Idea $idea) {}

    public function via($notifiable)
    {
        if (!env('EMAIL_NOTIFICATION', true)) {
            return ['database'];
        }

        return ['database', 'mail'];
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Idea Rejected')
            ->line('Your idea has been rejected.')
            ->line('Title: ' . $this->idea->title)
            ->action('View Idea', url('/ideas/' . $this->idea->id));
    }
}
