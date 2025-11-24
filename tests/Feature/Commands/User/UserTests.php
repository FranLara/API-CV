<?php

declare(strict_types=1);

namespace Tests\Feature\Commands\User;

use Tests\Feature\FeatureTests;

abstract class UserTests extends FeatureTests
{
    protected const string EXIT = 'exit';
    protected const string USER_SIGNATURE = 'user:';
    protected const string TRANSLATIONS = 'command.user.';
}
