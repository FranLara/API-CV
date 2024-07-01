<?php

declare(strict_types=1);

namespace App\Events\Users\Recruiters;

use App\BusinessObjects\Models\Users\Recruiter;
use Illuminate\Queue\SerializesModels;

class Saving
{
    use SerializesModels;

    public function __construct(public Recruiter $model)
    {
    }
}
