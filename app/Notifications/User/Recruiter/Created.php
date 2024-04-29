<?php
declare(strict_types = 1);

namespace App\Notifications\User\Recruiter;

use Illuminate\Notifications\Messages\MailMessage;

class Created extends Recruiter
{
	private const CREATION_TRANSLATIONS = self::RECRUITER_TRANSLATIONS . 'creation.';

	public function toMail(object $notifiable): MailMessage
	{
		$recruiter = ['email' => $this->user->getEmail(), 'linkedin_profile' => ''];
		if (!empty($this->user->getLinkedinProfile())) {
			$recruiter['linkedin_profile'] = $this->user->getLinkedinProfile();
		}

		return (new MailMessage())->subject(__(self::CREATION_TRANSLATIONS . 'subject', [
			'email' => $this->user->getEmail()]))
			->greeting(__(self::USER_TRANSLATIONS . 'greeting'))
			->line(__(self::CREATION_TRANSLATIONS . 'line_1', $recruiter))
			->line(__(self::USER_TRANSLATIONS . 'line_2', [
			'language' => $this->getLanguage($this->user->getLanguage())]));
	}
}
