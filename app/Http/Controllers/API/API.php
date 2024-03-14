<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class API extends Controller
{
	use Helpers;
	protected const API_GUARD = 'api.';
	protected const API_TRANSLATIONS = 'api.';
	protected const PSSWD_PARAMETER = 'password';
	protected const USERNAME_PARAMETER = 'username';
}
