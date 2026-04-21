<?php

namespace App\Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Idea;

class IdeaSentBackNotification extends Notification
{
    use Queueable;

    public Idea $idea; // ✅ PROPERTY

    /**
     * Create a new notification instance.
     */
    public function __construct(Idea $idea) // ✅ ACCEPT IDEA
    {
        $this->idea = $idea; // ✅ ASSIGN
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return env('EMAIL_NOTIFICATION', true)
            ? ['database', 'mail']
            : ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Idea Needs Revision')
            ->line('Your idea "' . $this->idea->title . '" was sent back for improvement.')
            ->line('Remark: ' . ($this->idea->review_remark ?? 'No remark provided'))
            ->action('Edit Idea', url('/ideas/' . $this->idea->id . '/edit'));
    }

    /**
     * Store in database (IMPORTANT 🔥)
     */
    public function toArray(object $notifiable): array
    {
        return [
            'idea_id' => $this->idea->id,
            'title' => $this->idea->title,
            'message' => 'Idea sent back for revision',
            'url' => '/ideas/' . $this->idea->id . '/edit',
        ];
    }
}