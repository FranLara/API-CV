<?php

declare(strict_types=1);

namespace App\Services\Health;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class Checker
{
    public const string STATUS_OK = 'ok';
    private const string STATUS_DEGRADED = 'degraded';

    public function check(): Collection
    {
        return collect(['database' => $this->getDatabaseStatus()]);
    }

    private function getDatabaseStatus(): string
    {
        try {
            DB::getPdo();
        } catch (Throwable $exception) {
            Log::channel('system')->critical($exception);

            return self::STATUS_DEGRADED;
        }

        return self::STATUS_OK;
    }
}
