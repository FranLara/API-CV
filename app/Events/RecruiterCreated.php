<?php

declare(strict_types=1);

namespace App\Events;

use App\BusinessObjects\DTOs\Users\Recruiter;

class RecruiterCreated
{
    public function __construct(public Recruiter $recruiter)
    {
    }
}
