<?php
declare(strict_types = 1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\BusinessObjects\Models\Users\Recruiter as RecruiterModel;
use App\Services\Users\Retriever as UserRetriever;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Retriever extends UserRetriever
{

	public function __construct(Transformer $transformer)
	{
		$this->transformer = $transformer;
	}

	public function retrieve(string $identifier): Recruiter
	{
		return $this->transformer->transform(RecruiterModel::findOrFail($identifier));
	}

	public function retrieveByField(string $field, $value): Recruiter
	{
		$model = RecruiterModel::firstWhere($field, $value);

		if (empty($model)) {
			throw (new ModelNotFoundException())->setModel(RecruiterModel::class, $value);
		}

		return $this->transformer->transform($model);
	}
}
