<?php

declare(strict_types=1);

namespace App\Notifications\User\Admin;

use Illuminate\Notifications\Messages\MailMessage;

class Updated extends Admin
{
    private const string UPDATE_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'update.';

    public function toMail(object $notifiable): MailMessage
    {
        return $this->getMailMessage($this->user, self::UPDATE_TRANSLATIONS);
    }
}
