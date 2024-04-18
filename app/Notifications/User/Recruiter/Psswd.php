<?php
declare(strict_types = 1);

namespace App\Notifications\User\Recruiter;

use Illuminate\Notifications\Messages\MailMessage;

class Psswd extends Recruiter
{
	private const PSSWD_TRANSLATIONS = self::RECRUITER_TRANSLATIONS . 'psswd.';

	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage())->subject(__(self::PSSWD_TRANSLATIONS . 'subject'))
			->greeting(__(self::PSSWD_TRANSLATIONS . 'greeting'))
			->line(__(self::PSSWD_TRANSLATIONS . 'line_1'))
			->line(__(self::PSSWD_TRANSLATIONS . 'line_2'))
			->line(__(self::PSSWD_TRANSLATIONS . 'line_3', [
			'endpoint' => env('API_DOMAIN') . '/token?username=username&password=password']))
			->line('')
			->line(__(self::PSSWD_TRANSLATIONS . 'line_4', ['username' => $this->user->getEmail()]))
			->line(__(self::PSSWD_TRANSLATIONS . 'line_5', ['psswd' => $this->user->getPsswd()]))
			->line('')
			->line(__(self::PSSWD_TRANSLATIONS . 'line_6'))
			->salutation(__(self::PSSWD_TRANSLATIONS . 'salutation', ['email' => env('MAIL_CONTACT')]));
	}
}
