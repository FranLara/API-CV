<?php

namespace App\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin;
use App\BusinessObjects\DTOs\Users\User;
use App\BusinessObjects\Models\Users\Admin as AdminModel;
use App\Services\Users\Retriever as UserRetriever;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Retriever extends UserRetriever
{
    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function retrieve(int $identifier): Admin
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
