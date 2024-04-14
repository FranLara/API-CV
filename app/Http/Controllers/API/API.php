<?php
declare(strict_types = 1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

abstract class API extends Controller
{
	use Helpers;
	public const NAME_PARAMETER = 'name';
	public const EMAIL_PARAMETER = 'email';
	public const PSSWD_PARAMETER = 'password';
	public const USERNAME_PARAMETER = 'username';
	public const LANGUAGE_PARAMETER = 'language';
	public const LINKEDIN_PARAMETER = 'linkedin_profile';
	protected const API_GUARD = 'api.';
	protected const API_TRANSLATIONS = 'api.';
	protected const REQUIRED_VALIDATION = 'required';
}
