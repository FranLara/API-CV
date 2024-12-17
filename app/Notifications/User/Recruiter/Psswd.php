<?php

declare(strict_types=1);

namespace App\Notifications\User\Recruiter;

use Illuminate\Notifications\Messages\MailMessage;

class Psswd extends Recruiter
{
    private const string PSSWD_TRANSLATIONS = self::RECRUITER_TRANSLATIONS . 'psswd.';

    public function toMail(object $notifiable): MailMessage
    {
        $endpoint = env('API_DOMAIN') . '/tokens?username=username&password=password';
        $acceptHeader = env('API_STANDARDS_TREE') . '.' . env('API_SUBTYPE') . '.' . env('API_VERSION');

        $line1 = __(self::PSSWD_TRANSLATIONS . 'line_1');
        $line5 = __(self::PSSWD_TRANSLATIONS . 'line_5');
        $subject = __(self::PSSWD_TRANSLATIONS . 'subject');
        $greeting = __(self::PSSWD_TRANSLATIONS . 'greeting');
        $line2 = __(self::PSSWD_TRANSLATIONS . 'line_2', ['endpoint' => $endpoint]);
        $line6 = __(self::PSSWD_TRANSLATIONS . 'line_6', ['accept' => $acceptHeader]);
        $line7 = __(self::PSSWD_TRANSLATIONS . 'line_7', ['email' => env('MAIL_CONTACT')]);
        $line4 = __(self::PSSWD_TRANSLATIONS . 'line_4', ['psswd' => $this->user->getPsswd()]);
        $line3 = __(self::PSSWD_TRANSLATIONS . 'line_3', ['username' => $this->user->getEmail()]);

        return (new MailMessage())->subject($subject)
            ->greeting($greeting)
            ->line($line1)
            ->line($line2)
            ->line($line3)
            ->line($line4)
            ->line($line5)
            ->line($line6)
            ->line($line7);
    }
}
