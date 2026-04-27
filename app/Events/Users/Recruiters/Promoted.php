<?php

declare(strict_types=1);

namespace App\Events\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;

class Promoted
{
    public function __construct(public Recruiter $recruiter)
    {
    }
}
