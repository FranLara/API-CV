<?php
declare(strict_types = 1);

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\API as APIController;
use App\Services\Users\Tokener;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;

class Token extends APIController
{

	public function request(Request $request, Tokener $tokener, JWT $tokenManager): JsonResponse
	{
		$request->validate([self::USERNAME_PARAMETER => 'required_with:' . self::PSSWD_PARAMETER,
			self::PSSWD_PARAMETER => 'required_with:' . self::USERNAME_PARAMETER]);
		$token = $tokener->getToken($request->only([self::USERNAME_PARAMETER, self::PSSWD_PARAMETER]));
		$expiresIn = $tokenManager->setToken($token)->getClaim('exp') - time();

		return response()->json(['token_type' => 'bearer', 'access_token' => $token, 'expires_in' => $expiresIn]);
	}
}
