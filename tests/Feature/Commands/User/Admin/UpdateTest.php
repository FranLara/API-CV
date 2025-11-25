<?php

declare(strict_types=1);

namespace Tests\Feature\Commands\User\Admin;

use App\BusinessObjects\Models\Users\Admin;

class UpdateTest extends AdminTests
{
    private const string USERNAME = 'test_username';
    private const string UPDATE_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'update.';

    public function testUpdate(): void
    {
        Admin::factory()->create(['username' => self::USERNAME]);

        $this->artisan(self::USER_SIGNATURE . 'update' . self::ADMIN_SIGNATURE)
             ->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'username.label'), self::USERNAME)
             ->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'password'), 'test_password')
             ->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'language'), 'en');

        $this->assertDatabaseCount('jobs', 3);
        $this->assertDatabaseCount('admins', 2);
        $this->assertDatabaseHas('jobs', ['queue' => 'default']);
        $this->assertDatabaseHas('jobs', ['queue' => 'listeners']);
        $this->assertDatabaseHas('admins', ['username' => self::USERNAME, 'language' => 'en']);
    }

    public function testUpdateExit(): void
    {
        $this->artisan(self::USER_SIGNATURE . 'update' . self::ADMIN_SIGNATURE)
             ->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'username.label'), self::EXIT);

        $this->assertDatabaseCount('admins', 1);
    }

    public function testUpdateNonExistingUser(): void
    {
        $this->artisan(self::USER_SIGNATURE . 'update' . self::ADMIN_SIGNATURE)
             ->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'username.label'), self::USERNAME)
             ->expectsOutput(__(self::UPDATE_TRANSLATIONS . 'non_existing', ['username' => self::USERNAME]))
             ->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'username.label'), self::EXIT);

        $this->assertDatabaseCount('admins', 1);
    }
}
