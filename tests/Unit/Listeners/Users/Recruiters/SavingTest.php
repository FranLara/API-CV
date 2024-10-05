<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Users\Recruiters;

use App\BusinessObjects\Models\Users\Recruiter;
use App\Events\Users\Recruiters\Saving as SavingEvent;
use App\Listeners\Users\Recruiters\Saving;
use Illuminate\Support\Str;
use Tests\Unit\Listeners\ListenerTests;

class SavingTest extends ListenerTests
{
    /**
     * @dataProvider providerField
     */
    public function testHandle(bool $expectedResult = true, string $field = null, $value = null): void
    {
        if (Str::of($field)->exactly('email')) {
            Recruiter::factory()->create([$field => $value]);
        }

        $variable = [];
        if (!empty($field)) {
            $variable = [$field => $value];
        }

        /** @var Recruiter $recruiter */
        $recruiter = Recruiter::factory()->make($variable);
        $result = (new Saving())->handle(new SavingEvent($recruiter));

        $this->assertEquals($expectedResult, $result);
    }

    public static function providerField(): array
    {
        return [[], [false, 'email', 'test@test.com']];
    }
}
