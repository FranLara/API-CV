<?php

declare(strict_types=1);

namespace App\Events\Users\Technicians;

use App\BusinessObjects\Models\Users\Technician;
use Illuminate\Queue\SerializesModels;

class Saving
{
    use SerializesModels;

    public function __construct(public Technician $technician)
    {
    }
}
