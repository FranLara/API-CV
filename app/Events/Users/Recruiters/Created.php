<?php

declare(strict_types=1);

namespace App\Events\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;

class Created
{
    public function __construct(public Recruiter $recruiter)
    {
    }
}
