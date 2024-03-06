<?php

namespace App\Notifications\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin as AdminDTO;
use App\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

abstract class Admin extends Notification
{
    protected const ADMIN_TRANSLATIONS = 'notification.admin.';

    protected AdminDTO $admin;

    public function __construct(AdminDTO $admin)
    {
        $this->admin = $admin;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    abstract public function toMail(object $notifiable): MailMessage;

    protected function getLanguage(string $language): string
    {
        return match ($language) {
            'es' => 'Castellano',
            'de' => 'Deutsch',
            default => 'English',
        };
    }
}
