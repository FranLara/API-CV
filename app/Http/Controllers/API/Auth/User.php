<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\BusinessObjects\DTOs\Users\Technician;
use App\BusinessObjects\DTOs\Utils\Token;
use App\Exceptions\Controllers\UserCreationException;
use App\Exceptions\Services\Users\Recruiters\CreationException;
use App\Http\Controllers\API\API as APIController;
use App\Services\Users\Recruiters\Creator;
use App\Services\Users\Technicians\Saver;
use App\Services\Users\Tokener;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PHPOpenSourceSaver\JWTAuth\JWT;
use Throwable;

class User extends APIController
{
    public function request(Request $request, Creator $creator): Response
    {
        $request->validate($this->getRequestValidationRules());

        $recruiter = new Recruiter(
            name: $request->input(self::NAME_PARAMETER),
            email: $request->input(self::EMAIL_PARAMETER),
            language: $request->input(self::LANGUAGE_PARAMETER),
            linkedinProfile: $request->input(self::LINKEDIN_PARAMETER)
        );

        try {
            $creator->create($recruiter);
        } catch (CreationException $exception) {
            throw new UserCreationException($exception);
        } catch (Throwable $exception) {
            $this->response->errorInternal($exception->getMessage());
        }

        return $this->response->created();
    }

    public function update(Request $request, Saver $saver, JWT $tokenManager): Response
    {
        $payload = $tokenManager->setToken($request->bearerToken())->getPayload();

        if ((!$payload->hasKey(Tokener::ROLE_CLAIM))
            || (!Str::of($payload->get(Tokener::ROLE_CLAIM))->exactly(Token::TECHNICIAN_ROLE))) {
            $this->response->errorForbidden(__(self::API_TRANSLATIONS . 'errors.forbidden.technician_only'));
        }

        $request->validate([self::GITHUB_PARAMETER => implode('|', [self::REQUIRED_VALIDATION, self::URL_VALIDATION])]);

        if (!$payload->hasKey(Tokener::USERNAME_CLAIM)) {
            $this->response->errorBadRequest(__(self::API_TRANSLATIONS . 'errors.forbidden.technician_only'));
        }

        $email = $payload->get(Tokener::USERNAME_CLAIM);
        $githubProfile = $request->input(self::GITHUB_PARAMETER);

        try {
            $saver->save(new Technician(email: $email, githubProfile: $githubProfile));
        } catch (Throwable $exception) {
            $this->response->errorInternal($exception->getMessage());
        }

        return $this->response->noContent();
    }

    private function getRequestValidationRules(): array
    {
        $emailValidation = [
            self::EMAIL_VALIDATION,
            self::REQUIRED_VALIDATION,
            'unique:recruiters,email',
            'unique:technicians,email',
        ];

        return [
            self::NAME_PARAMETER     => self::REQUIRED_VALIDATION,
            self::EMAIL_PARAMETER    => implode('|', $emailValidation),
            self::LINKEDIN_PARAMETER => 'sometimes|' . self::URL_VALIDATION,
            self::LANGUAGE_PARAMETER => [self::REQUIRED_VALIDATION, Rule::in(['en', 'es'])],
        ];
    }
}
