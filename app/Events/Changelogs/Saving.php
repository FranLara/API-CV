<?php

declare(strict_types=1);

namespace App\Events\Changelogs;

use App\BusinessObjects\Models\Changelog;
use Illuminate\Queue\SerializesModels;

class Saving
{
    use SerializesModels;

    public function __construct(public Changelog $model)
    {
    }
}
