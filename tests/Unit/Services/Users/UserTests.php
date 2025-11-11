<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use Tests\Unit\Services\ServiceTests;

abstract class UserTests extends ServiceTests
{
    protected function getExpectedField(string $field, bool $modified): string
    {
        if ($modified) {
            return $field . '_mod';
        }

        return $field;
    }
}
