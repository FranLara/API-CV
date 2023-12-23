<?php

namespace App\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Services\Users\Transformer as UserTransformer;
use Illuminate\Database\Eloquent\Model;

class Transformer extends UserTransformer
{

	public function transform(Model $model): Admin
	{
		return new Admin($model->username, $model->language, null, $model->id);
	}
}
