<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

$api->options('{catchall}','App\Http\Controllers\API\Root@options');
$api->get('index','App\Http\Controllers\API\Root@index');

$api->group(['middleware' => 'api.auth'], function ($api) {
	// Endpoints registered here will have the "foo" middleware applied.
});