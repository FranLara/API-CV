<?php

namespace App\Services;

use App\BusinessObjects\DTOs\DTO;

interface Saver
{
    public function save(DTO $dto);
}

