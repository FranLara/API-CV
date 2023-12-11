<?php

namespace App\BusinessObjects\Models\Users;

use Database\Factories\AdminFactory;

class Admin extends User
{
    public $timestamps = false;
    protected $fillable = ['username'];

    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }
}