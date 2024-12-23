<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class ModelSaved
{
    use SerializesModels;

    public function __construct(public Model $model)
    {
    }
}
