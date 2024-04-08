<?php
declare(strict_types = 1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Services\Users\Mapper as UserMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Mapper extends UserMapper
{

	public function map(DTO $dto, Model $recruiter): Recruiter
	{
		if (empty($recruiter->id)) {
			$recruiter->created_at = now();
		}
		if (!empty($dto->getLanguage())) {
			$recruiter->language = $dto->getLanguage();
		}
		if (!empty($dto->getPsswd())) {
			$recruiter->password = Hash::make($dto->getPsswd());
		}
		if (!empty($dto->getLinkedinProfile())) {
			$recruiter->linkedin_profile = $dto->getLinkedinProfile();
		}

		return $recruiter;
	}
}
