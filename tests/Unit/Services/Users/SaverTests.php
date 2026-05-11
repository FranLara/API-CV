<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use Tests\Unit\Services\ServiceTests;

abstract class SaverTests extends ServiceTests
{
    protected function getExpectedField(string $field, bool $modified): string
    {
        if ($modified) {
            return str_replace('.test_mod', '.testmod', $field . '_mod');
        }

        return $field;
    }
}
