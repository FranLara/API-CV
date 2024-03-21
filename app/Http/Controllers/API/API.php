<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

abstract class API extends Controller
{
	use Helpers;
	public const PSSWD_PARAMETER = 'password';
	public const USERNAME_PARAMETER = 'username';
	protected const API_GUARD = 'api.';
	protected const API_TRANSLATIONS = 'api.';
}
