<?php

declare(strict_types=1);

namespace App\Services\Changelogs;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\Models\Changelog as ChangelogModel;
use App\Services\Saver as SaverInterface;

class Saver implements SaverInterface
{
    protected Mapper $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(DTO $changelog): bool
    {
        $model = new ChangelogModel();

        $model = $this->mapper->map($changelog, $model);

        return $model->save();
    }
}
