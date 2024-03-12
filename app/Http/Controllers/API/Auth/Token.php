<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\API as APIController;

class Token extends APIController
{

	public function request()
	{
		//return $this->response->
		//return response()->json(['token_type' => 'bearer', 'expires_in' => auth('api')->guest()
		//	->factory()
		//	->getTTL() * 60,
		//	'access_token' => $tokener->getToken($user, collect($request->get('functionalities'))->all()),]);
	}
}
