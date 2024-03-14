<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\API as APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Token extends APIController
{

	public function request(Request $request)
	{
		$credentials = $request->only([self::USERNAME_PARAMETER, self::PSSWD_PARAMETER]);
		//return $this->response->
		//return response()->json(['token_type' => 'bearer', 'expires_in' => auth('api')->guest()
		//	->factory()
		//	->getTTL() * 60,
		//	'access_token' => $tokener->getToken($user, collect($request->get('functionalities'))->all()),]);

		return response()->json(['access_token' => Auth::guard(self::API_GUARD . 'admin')->attempt($credentials),
			'token_type' => 'bearer']);
	}
}
