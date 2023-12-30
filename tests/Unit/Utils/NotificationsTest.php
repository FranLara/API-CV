<?php

namespace Tests\Unit\Utils\Admins;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Notifications\Notification;
use App\Notifications\User\Admin\Created;
use App\Utils\Notifications as NotificationsUtil;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification as FacadeNotification;
use Tests\Unit\Services\ServiceTest;
use ReflectionClass;

class NotificationsTest extends ServiceTest
{

	/**
	 * @dataProvider providerNotification
	 */
	public function testSendMailNotification(Notification $notification, string $expectedLocale = '', string $expectedTo = null, string $locale = null, string $to = null): void
	{
		if (empty($expectedTo)) {
			$expectedTo = config('mail.notifications.internal');
		}

		FacadeNotification::fake();

		$notifications = new class() {
			use NotificationsUtil;
		};

		$class = new ReflectionClass(get_class($notifications));
		$method = $class->getMethod('sendMailNotification');
		$method->setAccessible(true);

		$method->invokeArgs($notifications, [$notification, $locale, $to]);

		FacadeNotification::assertSentOnDemand(Notification::class, function (Notification $notification, array $channels, object $notifiable) use ($expectedLocale, $expectedTo) {
			return ((Str::of($notifiable->routes['mail'])->exactly($expectedTo)) &&
				(Str::of($notification->locale)->exactly($expectedLocale)));
		});
		FacadeNotification::assertCount(1);
	}

	public static function providerNotification(): array
	{
		return [[new Created(new Admin())], [new Created(new Admin()), 'test_locale', null, 'test_locale']]; //[], [true], [true, true]];
	}
}