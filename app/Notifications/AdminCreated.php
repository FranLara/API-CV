<?php

namespace App\Notifications;

use App\BusinessObjects\DTOs\Users\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminCreated extends Notification implements ShouldQueue
{
    use Queueable;
    private const TRANSLATIONS = 'notification.admin.creation.';
    private Admin $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())->subject(__(self::TRANSLATIONS . 'subject', [
            'username' => $this->admin->getUsername()]))
            ->greeting(self::TRANSLATIONS . 'greeting')
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
}
