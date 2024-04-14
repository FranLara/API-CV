<?php
declare(strict_types = 1);

namespace App\Http\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Http\Controllers\API\API as APIController;
use App\Services\Users\Tokener;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\JWT;

class User extends APIController
{

	public function request(Request $request, Tokener $tokener, JWT $tokenManager): Response
	{
		$rules = [self::EMAIL_PARAMETER => self::REQUIRED_VALIDATION . '|email|unique:recruiters,email', // TODO Add unique to technicians
			self::NAME_PARAMETER => self::REQUIRED_VALIDATION, self::LANGUAGE_PARAMETER => Rule::in(['en', 'es']),
			self::LINKEDIN_PARAMETER => 'sometimes|url'];
		$request->validate($rules);

		$recruiter = new Recruiter($request->get(self::EMAIL_PARAMETER), $request->get(self::NAME_PARAMETER), $request->get(self::LANGUAGE_PARAMETER), null, $request->get(self::LINKEDIN_PARAMETER));

		return $this->response->created();
	}
}
