<?php
declare(strict_types = 1);

namespace App\Notifications\User\Recruiter;

use App\Notifications\User\Admin\Admin;
use Illuminate\Notifications\Messages\MailMessage;

class Psswd extends Recruiter
{
	private const string PSSWD_TRANSLATIONS = self::RECRUITER_TRANSLATIONS . 'psswd.';

	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage())->subject(__(self::PSSWD_TRANSLATIONS . 'subject'))
			->greeting(__(self::PSSWD_TRANSLATIONS . 'greeting'))
			->line(__(self::PSSWD_TRANSLATIONS . 'line_1', ['email' => $this->user->getEmail()]))
			->line(__(self::USER_TRANSLATIONS . 'line_2', [
			'language' => $this->getLanguage($this->user->getLanguage())]));
	}
}
