<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use App\BusinessObjects\DTOs\Users\Admin;
use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Notifications\Notification;
use App\Notifications\User\Admin\Created as AdminCreated;
use App\Notifications\User\Admin\Updated;
use App\Notifications\User\Recruiter\Created as RecruiterCreated;
use App\Notifications\User\Recruiter\Psswd;
use App\Utils\Notifications as NotificationUtil;
use Illuminate\Support\Facades\Notification as FacadeNotification;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    private const string LOCALE = 'test_locale';
    private const string TO = 'test_to@email.com';

    /**
     * @dataProvider providerNotification
     *
     * @throws ReflectionException
     */
    public function testSendMailNotification(
        Notification $notification,
        string $expectLocale = '',
        string $expectTo = null,
        string $locale = null,
        string $to = null
    ): void {
        if (empty($expectTo)) {
            $expectTo = config('mail.notifications.internal');
        }

        FacadeNotification::fake();

        $notifications = new class() {
            use NotificationUtil;
        };

        $class = new ReflectionClass(get_class($notifications));
        $method = $class->getMethod('sendMailNotification');
        $method->setAccessible(true);

        $method->invokeArgs($notifications, [$notification, $locale, $to]);

        FacadeNotification::assertSentOnDemand(get_class($notification),
            function (Notification $notification, array $channels, object $notifiable) use ($expectLocale, $expectTo) {
                return ((Str::of($notifiable->routes['mail'])->exactly($expectTo))
                        && (Str::of($notification->locale)->exactly($expectLocale)));
            });
        FacadeNotification::assertCount(1);
    }

    public static function providerNotification(): array
    {
        return [
            [new Updated(new Admin())],
            [new AdminCreated(new Admin())],
            [new RecruiterCreated(new Recruiter())],
            [new Psswd(new Recruiter()), '', self::TO, '', self::TO],
            [new Updated(new Admin()), self::LOCALE, null, self::LOCALE],
            [new AdminCreated(new Admin()), self::LOCALE, null, self::LOCALE],
            [new RecruiterCreated(new Recruiter()), self::LOCALE, null, self::LOCALE],
            [new Psswd(new Recruiter()), self::LOCALE, self::TO, self::LOCALE, self::TO],
        ];
    }
}
