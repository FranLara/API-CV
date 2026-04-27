<?php

declare(strict_types=1);

namespace App\Notifications\User\Recruiter;

use Illuminate\Notifications\Messages\MailMessage;

class Promoted extends Recruiter
{
    private const string PROMOTION_TRANSLATIONS = self::RECRUITER_TRANSLATIONS . 'promotion.';

    public function toMail(object $notifiable): MailMessage
    {
        $endpoint = config('api.domain') . '/accounts';

        $line2 = __(self::PROMOTION_TRANSLATIONS . 'line_2');
        $line4 = __(self::PROMOTION_TRANSLATIONS . 'line_4');
        $subject = __(self::PROMOTION_TRANSLATIONS . 'subject');
        $greeting = __(self::PROMOTION_TRANSLATIONS . 'greeting');
        $line3 = __(self::PROMOTION_TRANSLATIONS . 'line_3', ['endpoint' => $endpoint]);
        $line1 = __(self::PROMOTION_TRANSLATIONS . 'line_1', ['email' => $this->user->getEmail()]);

        return new MailMessage()->subject($subject)
                                ->greeting($greeting)
                                ->line($line1)
                                ->line($line2)
                                ->line($line3)
                                ->line($line4);
    }
}
