<?php

declare(strict_types=1);

namespace App\Notifications\User\Recruiter;

use Illuminate\Notifications\Messages\MailMessage;

class Psswd extends Recruiter
{
    private const string PSSWD_TRANSLATIONS = self::RECRUITER_TRANSLATIONS . 'psswd.';

    public function toMail(object $notifiable): MailMessage
    {
        $endpoint = env('API_DOMAIN') . '/token?username=username&password=password';
        $acceptHeader = env('API_STANDARDS_TREE') . '.' . env('API_SUBTYPE') . '.' . env('API_VERSION');

        return (new MailMessage())->subject(__(self::PSSWD_TRANSLATIONS . 'subject'))
                                  ->greeting(__(self::PSSWD_TRANSLATIONS . 'greeting'))
                                  ->line(__(self::PSSWD_TRANSLATIONS . 'line_1'))
                                  ->line(__(self::PSSWD_TRANSLATIONS . 'line_2', ['endpoint' => $endpoint]))
                                  ->line(__(self::PSSWD_TRANSLATIONS . 'line_3',
                                      ['username' => $this->user->getEmail()]))
                                  ->line(__(self::PSSWD_TRANSLATIONS . 'line_4', ['psswd' => $this->user->getPsswd()]))
                                  ->line(__(self::PSSWD_TRANSLATIONS . 'line_5'))
                                  ->line(__(self::PSSWD_TRANSLATIONS . 'line_6', ['accept' => $acceptHeader]))
                                  ->line(__(self::PSSWD_TRANSLATIONS . 'line_7', ['email' => env('MAIL_CONTACT')]));
    }
}
