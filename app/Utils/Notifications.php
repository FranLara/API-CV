<?php

declare(strict_types=1);

namespace App\Utils;

use App\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadeNotification;

trait Notifications
{
    protected function sendMailNotification(Notification $notification, string $locale = null, string $to = null): void
    {
        if (empty($to)) {
            $to = config('mail.notifications.internal');
        }

        $notification->locale($locale);
        FacadeNotification::route('mail', $to)->notify($notification);
    }
}