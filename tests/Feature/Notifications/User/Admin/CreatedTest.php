<?php

namespace Feature\Notifications\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Notifications\User\Admin\Created;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreatedTest extends TestCase
{
    public function testToMail(string $language): void
    {
        $admin = new Admin('test_username', $language);
        $notification = new Created(new Admin());

        $notification->locale($admin->getLanguage());
        $mail = $notification->toMail(new stdClass());

        $this->assertSame(__());
    }
}
