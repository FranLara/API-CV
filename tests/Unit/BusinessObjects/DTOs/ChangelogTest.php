<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessObjects\DTOs;

use App\BusinessObjects\DTOs\Changelog;
use PHPUnit\Framework\TestCase;

class ChangelogTest extends TestCase
{
    private const string TYPE = 'test_type';
    private const string ACTION = 'test_action';
    private const string ENTITY_ID = 'test_entity_id';
    private const string VALUE_PAYLOAD = 'test_value_payload';

    public function testConstructor(): void
    {
        $changelog = $this->getChangelog();

        $this->assertNull($changelog->getIdentifier());
        $this->assertSame(self::TYPE, $changelog->getType());
        $this->assertSame(self::ACTION, $changelog->getAction());
        $this->assertSame(self::ENTITY_ID, $changelog->getEntityId());
        $this->assertSame(self::VALUE_PAYLOAD, $changelog->getValuePayload());
    }

    public function testGetType(): void
    {
        $this->assertSame(self::TYPE, $this->getChangelog()->getType());
    }

    public function testGetAction(): void
    {
        $this->assertSame(self::ACTION, $this->getChangelog()->getAction());
    }

    public function testGetEntityId(): void
    {
        $this->assertSame(self::ENTITY_ID, $this->getChangelog()->getEntityId());
    }

    public function testGetValuePayload(): void
    {
        $this->assertSame(self::VALUE_PAYLOAD, $this->getChangelog()->getValuePayload());
    }

    private function getChangelog(): Changelog
    {
        return new Changelog(
            type: self::TYPE,
            action: self::ACTION,
            entityId: self::ENTITY_ID,
            valuePayload: self::VALUE_PAYLOAD
        );
    }
}
