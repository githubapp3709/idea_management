<?php

namespace App\Modules\Notification\Notifications;

use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class IdeaSubmittedNotification extends Notification
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
            'message' => 'New idea submitted for review',
            'submitted_by' => $this->idea->user->name,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Idea Submitted')
            ->line('A new idea has been submitted.')
            ->line('Title: ' . $this->idea->title)
            ->action('View Idea', url('/ideas/' . $this->idea->id));
    }
}
