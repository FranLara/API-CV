<?php

declare(strict_types=1);

namespace App\Notifications\User\Admin;

use Illuminate\Notifications\Messages\MailMessage;

class Created extends Admin
{
    private const string CREATION_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'creation.';

    public function toMail(object $notifiable): MailMessage
    {
        return $this->getMailMessage($this->user, self::CREATION_TRANSLATIONS);
    }
}
