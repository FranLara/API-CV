<?php

declare(strict_types=1);

namespace App\BusinessObjects\Models\Users;

use App\Events\Users\Recruiters\Saving;
use Database\Factories\RecruiterFactory;

class Recruiter extends User
{
    protected $fillable = ['id', 'email', 'name', 'password', 'language', 'linkedin_profile'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->dispatchesEvents['saving'] = Saving::class;
    }

    protected static function newFactory(): RecruiterFactory
    {
        return RecruiterFactory::new();
    }
}