<?php

namespace App\Models\Users;

use Database\Factories\AdminFactory;

class Admin extends User
{
    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }
}