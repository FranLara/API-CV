<?php

declare(strict_types=1);

namespace App\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin;
use App\BusinessObjects\Models\Users\Admin as AdminModel;
use App\Services\Transformer;
use App\Services\Users\Retriever as UserRetriever;
use Illuminate\Database\Eloquent\ModelNotFoundException;

readonly class Retriever extends UserRetriever
{
    public function __construct(private Transformer $transformer)
    {
    }

    public function retrieve(string $identifier): Admin
    {
        return $this->transformer->transform(AdminModel::findOrFail($identifier));
    }

    public function retrieveByField(string $field, $value): Admin
    {
        $model = AdminModel::firstWhere($field, $value);

        if (empty($model)) {
            throw (new ModelNotFoundException())->setModel(AdminModel::class, $value);
        }

        return $this->transformer->transform($model);
    }
}
