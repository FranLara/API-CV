<?php
declare(strict_types = 1);

namespace Tests\Unit\Utils;

use App\BusinessObjects\DTOs\Users\Admin;
use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Notifications\Notification;
use App\Notifications\User\Admin\Created as AdminCreated;
use App\Notifications\User\Admin\Updated;
use App\Notifications\User\Recruiter\Created as RecruiterCreated;
use App\Utils\Notifications as NotificationsUtil;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification as FacadeNotification;
use Tests\TestCase;
use ReflectionClass;
use ReflectionException;

class NotificationsTest extends TestCase
{
	private const LOCALE = 'test_locale';
	private const TO = 'test_to@email.com';

	/**
	 * @dataProvider providerNotification
	 *
	 * @throws ReflectionException
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

		FacadeNotification::assertSentOnDemand(get_class($notification), function (Notification $notification, array $channels, object $notifiable) use ($expectedLocale, $expectedTo) {
			return ((Str::of($notifiable->routes['mail'])->exactly($expectedTo)) &&
				(Str::of($notification->locale)->exactly($expectedLocale)));
		});
		FacadeNotification::assertCount(1);
	}

	public static function providerNotification(): array
	{
		return [[new AdminCreated(new Admin())], [new RecruiterCreated(new Recruiter())], [new Updated(new Admin())],
			[new AdminCreated(new Admin()), self::LOCALE, null, self::LOCALE],
			[new RecruiterCreated(new Recruiter()), self::LOCALE, null, self::LOCALE],
			[new Updated(new Admin()), self::LOCALE, null, self::LOCALE]];
	}
}
