<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\API as APIController;
use App\Services\Users\Tokener;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWT;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Token extends APIController
{
    public function __construct(private readonly JWT $tokenManager)
    {
    }

    public function options(): Response
    {
        $methods = [Request::METHOD_GET, Request::METHOD_OPTIONS, Request::METHOD_POST];

        return (new Response([], Response::HTTP_OK))->header('Allow', implode(', ', $methods));
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
    	try {
    		$token = $this->tokenManager->setToken($request->bearerToken())->refresh();
    	} catch (JWTException $exception) {
    		throw new UnauthorizedHttpException('jwt-auth', $exception->getMessage(), $exception, $exception->getCode());
    	}

    	$payload = $this->tokenManager->setToken($token)->getPayload()->toArray();
    	$payload['exp'] = time() + 1860;

    	$payload = $this->tokenManager->manager()->getPayloadFactory()->customClaims($payload)->make();

    	$token = $this->tokenManager->manager()->encode($payload)->get();

        return $this->getResponse($token);
    }

    private function getResponse(string $token): JsonResponse
    {
        $expiresIn = $this->tokenManager->setToken($token)->getClaim('exp') - time();

        return response()->json(['token_type' => 'bearer', 'access_token' => $token, 'expires_in' => $expiresIn]);
    }
}
