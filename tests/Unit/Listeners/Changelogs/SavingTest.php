<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Changelogs;

use App\BusinessObjects\Models\Changelog;
use App\Events\Changelogs\Saving as SavingEvent;
use App\Listeners\Changelogs\Saving;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Unit\Listeners\ListenerTests;

class SavingTest extends ListenerTests
{
    #[DataProvider('providerField')]
    public function testHandle(bool $expectedResult, ?string $field = null, $value = null): void
    {
        $variable = [];
        if (!empty($field)) {
            $variable = [$field => $value];
        }

        /** @var Changelog $changelog */
        $changelog = Changelog::factory()->make($variable);
        $result = new Saving()->handle(new SavingEvent($changelog));

        $this->assertEquals($expectedResult, $result);
    }

    public static function providerField(): array
    {
        return [[true], [false, 'type', 'test'], [false, 'value_payload', 'test']];
    }
}
