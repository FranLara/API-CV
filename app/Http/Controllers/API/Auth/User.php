<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Exceptions\Controllers\UserCreationException;
use App\Exceptions\Services\RecruiterCreationException;
use App\Http\Controllers\API\API as APIController;
use App\Services\Users\Recruiters\Creator;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;

class User extends APIController
{
    public function request(Request $request, Creator $creator): Response
    {
        $rules = [
            self::EMAIL_PARAMETER    => self::REQUIRED_VALIDATION . '|email|unique:recruiters,email',
            // TODO Add unique to technicians
            self::NAME_PARAMETER     => self::REQUIRED_VALIDATION,
            self::LANGUAGE_PARAMETER => [self::REQUIRED_VALIDATION, Rule::in(['en', 'es'])],
            self::LINKEDIN_PARAMETER => 'sometimes|url',
        ];
        $request->validate($rules);

        $recruiter = new Recruiter(
            name:            $request->get(self::NAME_PARAMETER),
            email:           $request->get(self::EMAIL_PARAMETER),
            language:        $request->get(self::LANGUAGE_PARAMETER),
            linkedinProfile: $request->get(self::LINKEDIN_PARAMETER)
        );

        try {
            $creator->create($recruiter);
        } catch (RecruiterCreationException $exception) {
            throw new UserCreationException($exception);
        } catch (Throwable $exception) {
            $this->response->errorInternal($exception->getMessage());
        }

        return $this->response->created();
    }
}
