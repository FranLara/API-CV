<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Collection;

trait Errors
{
    protected function getCollectionErrorMessage(string $variable, Collection $list, $input): string
    {
        return '- The ' . $variable . ' field must have the following values: "' . $list->implode('","')
               . '". (Wrong input => "' . $input . '")' . PHP_EOL;
    }
}
