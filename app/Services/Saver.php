<?php
namespace app\Services;

use App\BusinessObjects\DTOs\DTO;

interface Saver
{
    public function save(DTO $dto);
}

