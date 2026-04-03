<?php
namespace App\Modules\Notification\Notifications;

use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class IdeaApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(public Idea $idea) {}

    public function via($notifiable)
    {
        return env('EMAIL_NOTIFICATION', true)
        ? ['database', 'mail']
        : ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'idea_id' => $this->idea->id,
            'title' => $this->idea->title,
            'message' => 'Your idea has been approved 🎉',
            'status' => 'approved',
        ];
    }

    public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Idea Approved 🎉')
        ->line('Your idea has been approved.')
        ->line('Title: ' . $this->idea->title)
        ->action('View Idea', url('/ideas/' . $this->idea->id));
}

}