<?php
namespace app\Services\Users\Admins;

use App\Models\Users\Admin as AdminModel;
use app\DTOs\Users\Admin;
use app\Services\Users\Saver as SaverInterface;

class Saver implements SaverInterface
{
    private AdminModel $model;

    public function __construct(AdminModel $model)
    {
        $this->model = $model;
    }

    public function save(Admin $admin)
    {
        $this->model = $admin;
    }
}

