<?php

declare(strict_types=1);

namespace Tests\Feature\Commands\User\Admin;

use App\BusinessObjects\Models\Users\Admin;
use App\Events\ModelSaved;
use Illuminate\Support\Facades\Event;

class CreateTest extends AdminTests
{
    private const string USERNAME = 'test_username';
    private const string CREATION_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'creation.';

    public function testCreate(): void
    {
        $this->artisan(self::USER_SIGNATURE . 'create' . self::ADMIN_SIGNATURE)
             ->expectsQuestion(__(self::CREATION_TRANSLATIONS . 'username.label'), self::USERNAME)
             ->expectsQuestion(__(self::CREATION_TRANSLATIONS . 'password'), 'test_password')
             ->expectsQuestion(__(self::CREATION_TRANSLATIONS . 'language'), 'es');

        $this->assertDatabaseCount('jobs', 2);
        $this->assertDatabaseCount('admins', 2);
        $this->assertDatabaseHas('admins', ['username' => self::USERNAME, 'language' => 'es']);
    }

    public function testCreateExit(): void
    {
        $this->artisan(self::USER_SIGNATURE . 'create' . self::ADMIN_SIGNATURE)
             ->expectsQuestion(__(self::CREATION_TRANSLATIONS . 'username.label'), self::EXIT);

        $this->assertDatabaseCount('admins', 1);
    }

    public function testCreateExistingUser(): void
    {
    	Event::fake([ModelSaved::class]);

        Admin::factory()->create(['username' => self::USERNAME]);

        $this->artisan(self::USER_SIGNATURE . 'create' . self::ADMIN_SIGNATURE)
             ->expectsQuestion(__(self::CREATION_TRANSLATIONS . 'username.label'), self::USERNAME)
             ->expectsOutput(__(self::CREATION_TRANSLATIONS . 'existing', ['username' => self::USERNAME]))
             ->expectsQuestion(__(self::CREATION_TRANSLATIONS . 'username.label'), self::EXIT);

        $this->assertDatabaseCount('jobs', 0);
        $this->assertDatabaseCount('admins', 2);
    }
}
