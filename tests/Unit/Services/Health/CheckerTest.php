<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Health;

use App\Services\Health\Checker;
use DB;
use Illuminate\Support\Collection;
use Log;
use Psr\Log\LoggerInterface;
use Tests\TestCase;
use Throwable;

class CheckerTest extends TestCase
{
    private Checker $checker;

    public function testCheck(): void
    {
        DB::shouldReceive('getPdo')->andReturnSelf();

        $this->assertContains('database', $this->checker->check()->keys());
        $this->assertContains(Checker::STATUS_OK, $this->checker->check());
        $this->assertInstanceOf(Collection::class, $this->checker->check());
    }

    public function testCheckException(): void
    {
        DB::shouldReceive('getPdo')->andThrows($this->createMock(Throwable::class));
        Log::shouldReceive('channel')->andReturn($this->createMock(LoggerInterface::class));

        $this->assertContains('degraded', $this->checker->check());
        $this->assertContains('database', $this->checker->check()->keys());
        $this->assertInstanceOf(Collection::class, $this->checker->check());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->checker = new Checker();
    }
}
