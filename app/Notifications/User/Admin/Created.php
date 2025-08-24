<?php

declare(strict_types=1);

namespace App\Notifications\User\Admin;

use Illuminate\Notifications\Messages\MailMessage;

class Created extends Admin
{
    private const string CREATION_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'creation.';

    public function toMail(object $notifiable): MailMessage
    {
        $username = ['username' => $this->user->getUsername()];

        $mailMessage = new MailMessage()->subject(__(self::CREATION_TRANSLATIONS . 'subject', $username));

        $mailMessage->greeting(__(self::USER_TRANSLATIONS . 'greeting'))
                    ->line(__(self::CREATION_TRANSLATIONS . 'line_1', $username))
                    ->line(__(self::USER_TRANSLATIONS . 'line_2', [
                        'language' => $this->getLanguage($this->user->getLanguage())
                    ]));

        return $mailMessage;
    }
}
