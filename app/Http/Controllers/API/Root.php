<?php
declare(strict_types = 1);

namespace App\Http\Controllers\API;

use App\BusinessObjects\DTOs\Utils\Resource;
use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Root extends APIController
{
	private const TYPE_PARAMETER = 'type';
	private const STRING_PARAMETER = 'string';
	private const ENDPOINT_TRANSLATIONS = self::API_TRANSLATIONS . 'endpoints.';
	private const TOKEN_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'token.';
	private const ACCOUNT_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'account.';

	public function index(Request $request): Response
	{
		$resources = $this->getPublicResources($request);

		return $this->response->array([
			'Resources' => $resources->flatMap(fn (Resource $resource) => $resource->getResource())
				->toArray()]);
	}

	public function options(): Response
	{
		return (new Response([], Response::HTTP_OK))->header('Allow', implode(', ', [Request::METHOD_GET,
			Request::METHOD_OPTIONS, Request::METHOD_POST, Request::METHOD_PATCH]));
	}

	private function getPublicResources(Request $request): Collection
	{
		$resources = collect();

		$resources->push(new Resource($request, 'token', __(self::TOKEN_TRANSLATIONS . 'request'), [
			[self::NAME_PARAMETER => self::USERNAME_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
			[self::NAME_PARAMETER => self::PSSWD_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER]], Request::METHOD_POST));
		$resources->push(new Resource($request, 'account', __(self::ACCOUNT_TRANSLATIONS . 'request'), [
			[self::NAME_PARAMETER => self::EMAIL_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
			[self::NAME_PARAMETER => self::NAME_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
			[self::NAME_PARAMETER => self::LANGUAGE_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],
			[self::NAME_PARAMETER => self::LINKEDIN_PARAMETER, self::TYPE_PARAMETER => self::STRING_PARAMETER],], Request::METHOD_POST));

		return $resources;
	}
}
