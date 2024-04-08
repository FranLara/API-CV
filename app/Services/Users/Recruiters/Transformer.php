<?php
declare(strict_types = 1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Services\Users\Transformer as UserTransformer;
use Illuminate\Database\Eloquent\Model;

class Transformer extends UserTransformer
{

	public function transform(Model $model): Recruiter
	{
		return new Recruiter($model->email, $model->language, null, $model->linkedin_profile, $model->id);
	}
}
