<?php

namespace App\Notifications\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin as AdminDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

abstract class Admin extends Notification implements ShouldQueue
{
    use Queueable;

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
