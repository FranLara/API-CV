<?php

declare(strict_types=1);

namespace App\Notifications\User;

use App\BusinessObjects\DTOs\Users\User as UserDTO;
use App\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

abstract class User extends Notification
{
    protected const string USER_TRANSLATIONS = self::NOTIFICATION_TRANSLATIONS . 'user.';

    protected UserDTO $user;

    public function __construct(UserDTO $user)
    {
        $this->user = $user;
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
