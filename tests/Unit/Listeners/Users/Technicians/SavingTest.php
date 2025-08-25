<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Users\Technicians;

use App\BusinessObjects\Models\Users\Technician;
use App\Events\Users\Technicians\Saving as SavingEvent;
use App\Listeners\Users\Technicians\Saving;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Unit\Listeners\ListenerTests;

class SavingTest extends ListenerTests
{
    #[DataProvider('providerField')]
    public function testHandle(bool $expectedResult, ?string $field = null, $value = null): void
    {
        if (Str::of($field)->exactly('email')) {
            Technician::factory()->create([$field => $value]);
        }

        $variable = [];
        if (!empty($field)) {
            $variable = [$field => $value];
        }

        /** @var Technician $technician */
        $technician = Technician::factory()->make($variable);
        $result = new Saving()->handle(new SavingEvent($technician));

        $this->assertEquals($expectedResult, $result);
    }

    public static function providerField(): array
    {
        return [
            [true],
            [false, 'email', 'test@test.com'],
            [false, 'github_profile', 'test_github_profile'],
            [false, 'linkedin_profile', 'test_linkedin_profile'],
        ];
    }
}
