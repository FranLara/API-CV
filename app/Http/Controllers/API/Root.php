<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;

class Root extends APIController
{

	public function index(Request $request): Response
	{
		$resources = [
			'Resources' => [
				'request' => [$this->getResource($request, 'token', Request::METHOD_GET),
					$this->getResource($request, 'account', Request::METHOD_POST)]]];

		return $this->response->array($resources);
	}

	public function options(): Response
	{
		return (new Response([], Response::HTTP_OK))->header('Allow', implode(', ', [Request::METHOD_GET,
			Request::METHOD_OPTIONS, Request::METHOD_POST, Request::METHOD_PATCH]));
	}

	private function getResource(Request $request, string $resource, string $type): array
	{
		return [$resource => ['type' => $type, 'endpoint' => $request->getSchemeAndHttpHost() . '/' . $resource]];
	}
}
