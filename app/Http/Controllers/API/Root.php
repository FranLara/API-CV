<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\BusinessObjects\DTOs\Utils\Resource;
use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PHPOpenSourceSaver\JWTAuth\JWT;

class Root extends APIController
{
    private const string TYPE_PARAMETER = 'type';
    private const string STRING_PARAMETER = 'string';
    private const string ENDPOINT_TRANSLATIONS = self::API_TRANSLATIONS . 'endpoints.';
    private const string TOKEN_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'tokens.';
    private const string ACCOUNT_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'accounts.';

    public function index(Request $request, JWT $tokenManager): Response
    {
        $resources = $this->getPublicResources($request);

        $token = $request->bearerToken();
        if ((!empty($token)) && (count(explode('.', $token)) == 3) && ($tokenManager->setToken($token)->check())) {
            $resources = $resources->merge($this->getTokenedResources($request, $tokenManager));
        }

        return $this->response->array([
            'Resources' => $resources->flatMap(fn(Resource $resource) => $resource->getResource())->toArray()
        ]);
    }

    public function options(): Response
    {
        $methods = [Request::METHOD_GET, Request::METHOD_OPTIONS, Request::METHOD_POST];

        return (new Response([], Response::HTTP_OK))->header('Allow', implode(', ', $methods));
    }

    private function getPublicResources(Request $request): Collection
    {
        $resources = collect();

        $resources->push(new Resource(request: $request, path: 'tokens (' . Request::METHOD_POST . ')',
            type: Request::METHOD_POST, parameters: [
                [self::NAME_PARAMETER => self::USERNAME_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
                [self::NAME_PARAMETER => self::PSSWD_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER]
            ], description: __(self::TOKEN_TRANSLATIONS . 'request')));
        $resources->push(new Resource(request: $request, path: 'accounts', type: Request::METHOD_POST, parameters: [
            [self::NAME_PARAMETER => self::EMAIL_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
            [self::NAME_PARAMETER => self::NAME_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
            [self::NAME_PARAMETER => self::LANGUAGE_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
            [self::NAME_PARAMETER => self::LINKEDIN_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
        ], description: __(self::ACCOUNT_TRANSLATIONS . 'request')));

        return $resources;
    }

    private function getTokenedResources(Request $request, JWT $tokenManager): Collection
    {
        $resources = collect();

        $resources->push(new Resource(request: $request, path: 'tokens (' . Request::METHOD_GET . ')',
            description: __(self::TOKEN_TRANSLATIONS . 'refresh')));

        return $resources;
    }
}
