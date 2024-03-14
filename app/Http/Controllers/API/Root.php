<?php

namespace App\Http\Controllers\API;

use App\BusinessObjects\DTOs\Utils\Resource;
use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Root extends APIController
{
	private const NAME_PARAMETER = 'name';
	private const TYPE_PARAMETER = 'type';
	private const STRING_PARAMETER = 'string';
	private const ENDPOINT_TRANSLATIONS = self::API_TRANSLATIONS . 'endpoints.';
	private const TOKEN_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'token.';

	public function index(Request $request): Response
	{
		$resources = $this->getPublicEndpoints($request);

		return $this->response->array([
			'Resources' => $resources->map(fn (Resource $resource) => $resource->getResource())
				->toArray()]);
	}

	public function options(): Response
	{
		return (new Response([], Response::HTTP_OK))->header('Allow', implode(', ', [Request::METHOD_GET,
			Request::METHOD_OPTIONS, Request::METHOD_POST, Request::METHOD_PATCH]));
	}

	private function getPublicEndpoints(Request $request): Collection
	{
		$resources = collect();

		$resources->push(new Resource($request, 'token', __(self::TOKEN_TRANSLATIONS . 'request'), [
			[self::NAME_PARAMETER => self::USERNAME_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
			[self::NAME_PARAMETER => self::PSSWD_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER]]));

		return $resources;
	}
}
