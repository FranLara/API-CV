<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\Users\Admin;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

abstract class UserTests extends TestCase
{
    protected const string PSSWD = 'test_psswd';
    protected const string LANGUAGE = 'test_language';
    protected const string IDENTIFIER = 'test_identifier';
}
