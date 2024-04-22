<?php
declare(strict_types = 1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Exceptions\Services\RecruiterCreationException;
use App\Notifications\User\Recruiter\Created;
use App\Notifications\User\Recruiter\Psswd;
use App\Utils\Notifications as NotificationUtils;
use Illuminate\Support\Str;

class Creator
{
	use NotificationUtils;
	private Saver $saver;

	public function __construct(Saver $saver)
	{
		$this->saver = $saver;
	}

	public function create(Recruiter $recruiter): void
	{
		$recruiter->setPsswd(Str::random());

		$userSaved = $this->saver->save($recruiter);

		if (empty($userSaved)) {
			throw new RecruiterCreationException($recruiter);
		}

		$this->sendMailNotification(new Created($recruiter));
		$this->sendMailNotification(new Psswd($recruiter), $recruiter->getLanguage(), $recruiter->getEmail());
	}
}