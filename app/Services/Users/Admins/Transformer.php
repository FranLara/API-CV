<?php

namespace App\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Services\Users\Transformer as UserTransformer;
use Illuminate\Database\Eloquent\Model;

class Transformer extends UserTransformer
{

    public function transform(Model $model): Admin
    {
        $admin = new Admin($model->username, $model->language);

        if (!empty($model->id)) {
            $admin->setIdentifier($model->id);
        }

        return $admin;
    }
}
