<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\BusinessObjects\Models\Users\Admin;
use App\BusinessObjects\Models\Users\Recruiter;
use App\BusinessObjects\Models\Users\Technician;
use App\Events\ModelSaved as ModelSavedEvent;
use App\Listeners\ModelSaved;
use App\Services\Changelogs\Mapper;
use App\Services\Changelogs\Saver;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\DataProvider;

class ModelSavedTest extends ListenerTests
{
    #[DataProvider('providerModel')]
    public function testHandle(Model $model): void
    {
        $model = $model::factory()->create();
        $listener = new ModelSaved(new Saver(new Mapper()));

        $listener->handle(new ModelSavedEvent($model));

        $this->assertDatabaseCount('changelogs', 1);
        $this->assertDatabaseHas('changelogs', ['type' => get_class($model)]);
    }

    public static function providerModel(): array
    {
        return [[new Admin()], [new Recruiter()], [new Technician()]];
    }
}
