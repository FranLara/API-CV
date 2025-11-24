<?php

declare(strict_types=1);

namespace App\Notifications\User\Recruiter;

use Illuminate\Notifications\Messages\MailMessage;

class Created extends Recruiter
{
    private const string CREATION_TRANSLATIONS = self::RECRUITER_TRANSLATIONS . 'creation.';

    public function toMail(object $notifiable): MailMessage
    {
        $recruiter = ['email' => $this->user->getEmail(), 'linkedin_profile' => ''];
        if (!empty($this->user->getLinkedinProfile())) {
            $recruiter['linkedin_profile'] = $this->user->getLinkedinProfile();
        }

        $subject = __(self::CREATION_TRANSLATIONS . 'subject', ['email' => $this->user->getEmail()]);
        $greeting = __(self::USER_TRANSLATIONS . 'greeting');
        $line1 = __(self::CREATION_TRANSLATIONS . 'line_1', $recruiter);
        $line2 = __(self::USER_TRANSLATIONS . 'line_2', ['language' => $this->getLanguage($this->user->getLanguage())]);

        return new MailMessage()->subject($subject)->greeting($greeting)->line($line1)->line($line2);
    }
}
