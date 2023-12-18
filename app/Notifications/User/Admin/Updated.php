<?php

namespace App\Notifications\User\Admin;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Updated extends Admin implements ShouldQueue
{
    private const UPDATE_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'update.';

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())->subject(__(self::UPDATE_TRANSLATIONS . 'subject', [
            'username' => $this->admin->getUsername()
        ]))
                                  ->greeting(__(self::ADMIN_TRANSLATIONS . 'greeting'))
                                  ->line('The introduction to the notification.')
                                  ->action('Notification Action', url('/'))
                                  ->line('Thank you for using our application!');
    }
}
