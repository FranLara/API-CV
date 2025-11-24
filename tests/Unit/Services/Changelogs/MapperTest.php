<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Changelogs;

use App\BusinessObjects\DTOs\Changelog as ChangelogDTO;
use App\BusinessObjects\Models\Changelog;
use App\Services\Changelogs\Mapper;
use Tests\TestCase;

class MapperTest extends TestCase
{
    private const string TYPE = 'test_type';
    private const string ENTITY_ID = 'test_entity_id';
    private const string VALUE_PAYLOAD = 'test_valuePayload';

    public function testMap(): void
    {
        $changelog = new ChangelogDTO(entityId: self::ENTITY_ID, type: self::TYPE, valuePayload: self::VALUE_PAYLOAD);
        $changelog = new Mapper()->map($changelog, new Changelog());

        $this->assertSame(self::TYPE, $changelog->type);
        $this->assertSame(self::ENTITY_ID, $changelog->entity_id);
        $this->assertSame(self::VALUE_PAYLOAD, $changelog->value_payload);
        $this->assertGreaterThan(now()->subMinute(), $changelog->created_at);
    }
}
