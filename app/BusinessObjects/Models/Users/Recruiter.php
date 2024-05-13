<?php

declare(strict_types=1);

namespace App\BusinessObjects\Models\Users;

use App\Events\ModelSaved;
use Database\Factories\RecruiterFactory;

class Recruiter extends User
{
    protected $dispatchesEvents = ['saved' => ModelSaved::class];

    protected $fillable = ['id', 'email', 'name', 'password', 'language', 'linkedin_profile'];

    protected static function newFactory(): RecruiterFactory
    {
        return RecruiterFactory::new();
    }
}