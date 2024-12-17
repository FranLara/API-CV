<?php

declare(strict_types=1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Services\Users\Transformer as UserTransformer;
use Illuminate\Database\Eloquent\Model;

readonly class Transformer extends UserTransformer
{
    public function transform(Model $model): Recruiter
    {
        return new Recruiter(
            identifier:      $model->id,
            name:            $model->name,
            email:           $model->email,
            language:        $model->language,
            linkedinProfile: $model->linkedin_profile
        );
    }
}
