<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

$api->options('index','App\Http\Controllers\API\Root@index');

$api->group(['middleware' => 'api.auth'], function ($api) {
	// Endpoints registered here will have the "foo" middleware applied.
});