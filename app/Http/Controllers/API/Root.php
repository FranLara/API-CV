<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Symfony\Component\HttpFoundation\Request;

class Root extends APIController
{
    public function index(): Response
    {
        return $this->response->array(['foo' => 'bar']);
    }

    public function options(): Response
    {
        return (new Response([], Response::HTTP_OK))->header('Allow',
            implode(', ', [Request::METHOD_GET, Request::METHOD_OPTIONS, Request::METHOD_POST]));
    }
}
