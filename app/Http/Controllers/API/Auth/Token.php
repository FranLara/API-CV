<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\API as APIController;
use App\Services\Users\Tokener;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWT;

class Token extends APIController
{
    public function __construct(private readonly JWT $tokenManager)
    {
    }

    public function request(Request $request, Tokener $tokener): JsonResponse
    {
        $request->validate([
            self::USERNAME_PARAMETER => 'required_with:' . self::PSSWD_PARAMETER,
            self::PSSWD_PARAMETER    => 'required_with:' . self::USERNAME_PARAMETER
        ]);
        $token = $tokener->getToken($request->only([self::USERNAME_PARAMETER, self::PSSWD_PARAMETER]));

        return $this->getResponse($token);
    }

    public function refresh(Request $request): JsonResponse
    {
    	$token = $this->tokenManager->setToken($request->bearerToken())->refresh();
        $token = $this->tokenManager->setToken($token)->claims(['exp' => time() + 1860])->getToken()->get();

        return $this->getResponse($token);
    }

    private function getResponse(string $token): JsonResponse
    {
        $expiresIn = $this->tokenManager->setToken($token)->getClaim('exp') - time();

        return response()->json(['token_type' => 'bearer', 'access_token' => $token, 'expires_in' => $expiresIn]);
    }
}
