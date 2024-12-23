<?php
declare(strict_types = 1);

namespace App\Services;

use App\BusinessObjects\DTOs\DTO;
use Illuminate\Database\Eloquent\Model;

interface Mapper
{

	public function map(DTO $dto, Model $model): Model;
}
