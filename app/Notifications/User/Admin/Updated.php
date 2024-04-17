<?php
declare(strict_types = 1);

namespace App\Notifications\User\Admin;

use Illuminate\Notifications\Messages\MailMessage;

class Updated extends Admin
{
	private const string UPDATE_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'update.';

	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage())->subject(__(self::UPDATE_TRANSLATIONS . 'subject', [
			'username' => $this->user->getUsername()]))
			->greeting(__(self::USER_TRANSLATIONS . 'greeting'))
			->line(__(self::UPDATE_TRANSLATIONS . 'line_1', ['username' => $this->user->getUsername()]))
			->line(__(self::USER_TRANSLATIONS . 'line_2', [
			'language' => $this->getLanguage($this->user->getLanguage())]));
	}
}
