<?php

namespace Feature\Commands\User\Admin;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function testCommand(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
