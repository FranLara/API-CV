<?php

namespace App\Models\Users;

use Database\Factories\RecruiterFactory;

class Recruiter extends User
{
    protected static function newFactory(): RecruiterFactory
    {
        return RecruiterFactory::new();
    }
}