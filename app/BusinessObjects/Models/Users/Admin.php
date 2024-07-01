<?php

declare(strict_types=1);

namespace App\BusinessObjects\Models\Users;

use App\Events\Users\Admins\Saving;
use Database\Factories\AdminFactory;

class Admin extends User
{
    protected $fillable = ['id', 'username', 'password', 'language'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->dispatchesEvents['saving'] = Saving::class;
    }

    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }
}