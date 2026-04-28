<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\BusinessObjects\Models\Changelog;
use App\BusinessObjects\Models\Users\Admin;
use App\BusinessObjects\Models\Users\Recruiter;
use App\BusinessObjects\Models\Users\Technician;
use App\Events\ModelDeleted as ModelDeletedEvent;
use App\Listeners\ModelDeleted;
use App\Services\Changelogs\Mapper;
use App\Services\Changelogs\Saver;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\DataProvider;

class ModelDeletedTest extends ListenerTests
{
    #[DataProvider('providerModel')]
    public function testHandle(Model $model): void
    {
        $model = $model::factory()->create();
        $listener = new ModelDeleted(new Saver(new Mapper()));

        $listener->handle(new ModelDeletedEvent($model));

        $this->assertDatabaseCount('changelogs', 1);
        $this->assertDatabaseHas('changelogs', ['type' => get_class($model), 'action' => Changelog::ACTION_DELETED]);
    }

    public static function providerModel(): array
    {
        return [[new Admin()], [new Recruiter()], [new Technician()]];
    }
}
