<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\API as APIController;
use App\Services\Health\Checker;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Str;

class Health extends APIController
{
    public function check(Checker $checker): Response
    {
        $status = $checker->check();
        $statusCode = Response::HTTP_OK;

        if (!Str::of($status)->exactly(Checker::STATUS_OK)) {
            $statusCode = Response::HTTP_SERVICE_UNAVAILABLE;
        }

        return new Response(['status' => $status, 'timestamp' => now()->toIso8601String()], $statusCode);
    }

    public function options(): Response
    {
        $methods = [Request::METHOD_GET, Request::METHOD_OPTIONS];

        return new Response([], Response::HTTP_OK)->header('Allow', implode(', ', $methods));
    }
}
