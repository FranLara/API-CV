<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Users\Admins;

use App\BusinessObjects\Models\Changelog;
use App\BusinessObjects\Models\Users\Admin;
use App\Events\Users\Admins\Saving as SavingEvent;
use App\Listeners\Users\Admins\Saving;
use Illuminate\Support\Str;
use Tests\Unit\Listeners\ListenerTest;

class SavingTest extends ListenerTest
{
    /**
     * @dataProvider providerField
     */
    public function testHandle(bool $expectedResult = true, string $field = null, $value = null): void
    {
        if (Str::of($field)->exactly('username')) {
            Admin::factory()->create([$field => $value]);
        }

        $variable = [];
        if (!empty($field)) {
            $variable = [$field => $value];
        }

        /** @var Admin $admin */
        $admin = Admin::factory()->make($variable);
        $result = (new Saving())->handle(new SavingEvent($admin));

        $this->assertEquals($expectedResult, $result);
    }

    public static function providerField(): array
    {
        return [[], [false, 'username', 'test']];
    }
}
