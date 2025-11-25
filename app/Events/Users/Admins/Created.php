<?php

declare(strict_types=1);

namespace App\Events\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin;

class Created
{
    public function __construct(public Admin $admin)
    {
    }
}
