<?php
namespace App\Services\Users\Admins;

use App\Models\Users\Admin as AdminModel;
use App\DTOs\Users\Admin;
use App\Services\Users\Admins\Admin as AdminService;
use App\Services\Users\Saver as SaverInterface;

class Saver extends AdminService implements SaverInterface
{

    public function save(Admin $admin)
    {
        $model = $this->getMappedModel($admin);
    }

    private function getMappedModel(Admin $admin): AdminModel
    {
        $model = new AdminModel();

        if (!empty($admin->getIdentifier())) {
            $model = $this->getModel($admin->getIdentifier());
        }

        return $model;
    }
}

