<?php
declare(strict_types = 1);

namespace App\Services;

use App\BusinessObjects\DTOs\DTO;
use Illuminate\Database\Eloquent\Model;

interface Transformer
{
	public function transform(Model $model): DTO;
}
