<?php

namespace App\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin;
use App\BusinessObjects\Models\Users\Admin as AdminModel;
use App\Services\Users\Retriever as UserRetriever;

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
}
