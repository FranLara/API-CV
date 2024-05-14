<?php

declare(strict_types=1);

namespace App\Services\Changelogs;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\Models\Changelog;
use App\Services\Mapper as MapperInterface;
use Illuminate\Database\Eloquent\Model;

class Mapper implements MapperInterface
{

    public function map(DTO $dto, Model $changelog): Changelog
    {
        $changelog->created_at = now();
        $changelog->type = $dto->getType();
        $changelog->entity_id = $dto->getEntityId();
        $changelog->value_payload = $dto->getValuePayload();

        return $changelog;
    }
}
