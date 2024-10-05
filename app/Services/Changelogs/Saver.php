<?php

declare(strict_types=1);

namespace App\Services\Changelogs;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\Models\Changelog as ChangelogModel;
use App\Services\Saver as SaverInterface;

readonly class Saver implements SaverInterface
{
    public function __construct(protected Mapper $mapper)
    {
    }

    public function save(DTO $changelog): bool
    {
        $model = new ChangelogModel();

        $model = $this->mapper->map($changelog, $model);

        return $model->save();
    }
}
