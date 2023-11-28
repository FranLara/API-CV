<?php

namespace App\Models\Users;

use Database\Factories\TechnicianFactory;

class Technician extends User
{
    protected static function newFactory(): TechnicianFactory
    {
        return TechnicianFactory::new();
    }
}