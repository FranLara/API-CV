<?php

namespace App\Notifications\User\Admin;

use Illuminate\Notifications\Messages\MailMessage;

class Created extends Admin
{
    private const CREATION_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'creation.';

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())->subject(__(self::CREATION_TRANSLATIONS . 'subject', [
            'username' => $this->admin->getUsername()
        ]))->greeting(__(self::ADMIN_TRANSLATIONS . 'greeting'))->line(__(self::CREATION_TRANSLATIONS . 'line_1',
            ['username' => $this->admin->getUsername()]))->line(__(self::ADMIN_TRANSLATIONS . 'line_2',
            ['language' => $this->getLanguage($this->admin->getLanguage())]));
    }
}
