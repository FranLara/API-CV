<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;

class Root extends APIController
{
    public function index(): Response
    {
        return $this->response->array(['foo' => 'bar']);
    }
}
