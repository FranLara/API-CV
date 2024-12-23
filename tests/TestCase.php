<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }
}
