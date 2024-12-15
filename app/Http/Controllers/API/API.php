<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

abstract class API extends Controller
{
    use Helpers;

    public const string NAME_PARAMETER = 'name';
    public const string EMAIL_PARAMETER = 'email';
    public const string PSSWD_PARAMETER = 'password';
    public const string USERNAME_PARAMETER = 'username';
    public const string LANGUAGE_PARAMETER = 'language';
    public const string LINKEDIN_PARAMETER = 'linkedin_profile';

    protected const string API_TRANSLATIONS = 'api.';
    protected const string REQUIRED_VALIDATION = 'required';
}
