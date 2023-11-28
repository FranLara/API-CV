<?php

namespace App\Models\Users;

use Database\Factories\RecruiterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recruiter extends User
{
    protected static function newFactory(): RecruiterFactory
    {
        return RecruiterFactory::new();
    }
}