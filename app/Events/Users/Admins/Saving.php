<?php

declare(strict_types=1);

namespace App\Events\Users\Admins;

use App\BusinessObjects\Models\Users\Admin;
use Illuminate\Queue\SerializesModels;

class Saving
{
    use SerializesModels;

    public function __construct(public Admin $model)
    {
    }
}
