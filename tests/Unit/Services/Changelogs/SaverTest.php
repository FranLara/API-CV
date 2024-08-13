<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Changelogs;

use App\BusinessObjects\DTOs\Changelog as ChangelogDTO;
use App\BusinessObjects\Models\Changelog;
use App\Services\Changelogs\Mapper;
use App\Services\Changelogs\Saver;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\MockObject\Exception;
use Tests\Unit\Services\ServiceTest;

class SaverTest extends ServiceTest
{
    private const string TYPE = 'test_type';
    private const string ENTITY_ID = 'test_entity_id';
    private const string VALUE_PAYLOAD = 'test_valuePayload';

    /**
     * @throws Exception
     */
    public function testSave(): void
    {
        Event::fake();

        $changelog = ['type' => self::TYPE, 'entity_id' => self::ENTITY_ID, 'value_payload' => self::VALUE_PAYLOAD];
        $mapper = $this->createConfiguredMock(Mapper::class, ['map' => new Changelog($changelog)]);
        (new Saver($mapper))->save(new ChangelogDTO(entityId: self::ENTITY_ID, type: self::TYPE,
            valuePayload: self::VALUE_PAYLOAD));
        $changelog = Changelog::where(['type' => self::TYPE, 'entity_id' => self::ENTITY_ID])->first();

        $this->assertSame(self::TYPE, $changelog->type);
        $this->assertSame(self::ENTITY_ID, $changelog->entity_id);
        $this->assertSame(self::VALUE_PAYLOAD, $changelog->value_payload);
    }
}
