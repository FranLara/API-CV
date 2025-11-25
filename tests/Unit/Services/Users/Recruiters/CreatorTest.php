<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Exceptions\Services\Users\Recruiters\CreationException;
use App\Services\Saver;
use App\Services\Users\Recruiters\Creator;
use PHPUnit\Framework\MockObject\Exception;
use Tests\Unit\Services\ServiceTests;

class CreatorTest extends ServiceTests
{
    /**
     * @throws CreationException
     * @throws Exception
     */
    public function testCreate(): void
    {
        $this->getCreator()->create(new Recruiter());

        $this->assertDatabaseCount('jobs', 1);
        $this->assertDatabaseHas('jobs', ['queue' => 'listeners']);
    }

    /**
     * @throws Exception
     */
    public function testCreateRecruiterCreationException(): void
    {
        $this->expectException(CreationException::class);

        $this->getCreator(false)->create(new Recruiter());
    }

    /**
     * @throws Exception
     */
    private function getCreator(bool $saved = true): Creator
    {
        return new Creator($this->createConfiguredMock(Saver::class, ['save' => $saved]));
    }
}
