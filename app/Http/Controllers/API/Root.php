<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\Log;

class Root extends APIController
{
	public function index(): Response
	{
		Log::warning('Hola');
		return $this->response->array(['foo'=>'bar']);
	}
}
