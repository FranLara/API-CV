<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Exceptions\Services\RecruiterCreationException;
use App\Services\Users\Recruiters\Creator;
use App\Services\Users\Recruiters\Saver;
use Tests\Unit\Services\ServiceTests;

class CreatorTest extends ServiceTests
{
    /**
     * @throws RecruiterCreationException
     */
    public function testCreate(): void
    {
        $this->getCreator(true)->create(new Recruiter());

        $this->assertDatabaseCount('jobs', 1);
        $this->assertDatabaseHas('jobs', ['queue' => 'listeners']);
    }

    public function testCreateRecruiterCreationException(): void
    {
        $this->expectException(RecruiterCreationException::class);

        $this->getCreator(false)->create(new Recruiter());
    }

    private function getCreator(bool $saved): Creator
    {
        return new Creator($this->createConfiguredMock(Saver::class, ['save' => $saved]));
    }
}
