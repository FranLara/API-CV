<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Collection;

trait Errors
{
    protected function getCollectionErrorMessage(string $variable, Collection $list, $input): string
    {
        $errorText = '- The %s field must have the following values: "%s". (Wrong input => "%s")' . PHP_EOL;

        return sprintf($errorText, $variable, $list->implode('","'), $input);
    }
}
