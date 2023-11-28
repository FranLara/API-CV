<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Token extends APIController
{
    public function guest(): JsonResponse
    {
        return response()->json([
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->guest()->factory()->getTTL() * 60,
            'access_token' => $tokener->getToken($user, collect($request->get('functionalities'))->all()),
        ]);
    }

    public function request(): Response
    {
        return (new Response([], Response::HTTP_OK))->header('Allow',
            implode(', ', [Request::METHOD_GET, Request::METHOD_OPTIONS, Request::METHOD_POST]));
    }

    public function registered(): Response
    {

    }
}
