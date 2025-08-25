<?php

declare(strict_types=1);

namespace App\BusinessObjects\Models\Users;

use App\Events\Users\Technicians\Saving;
use Database\Factories\TechnicianFactory;

class Technician extends User
{
    protected $fillable = ['id', 'email', 'name', 'password', 'language', 'github_profile', 'linkedin_profile'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->dispatchesEvents['saving'] = Saving::class;
    }

    protected static function newFactory(): TechnicianFactory
    {
        return TechnicianFactory::new();
    }
}