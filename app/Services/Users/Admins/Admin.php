<?php
namespace App\Services\Users\Admins;

use App\Models\Users\Admin as AdminModel;

abstract class Admin
{
    protected function getModel(int $identifier): AdminModel
    {
        return AdminModel::findOrFail($identifier);
    }
}

