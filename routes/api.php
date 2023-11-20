<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
$api->options('indexo','App\Http\Controllers\API\Root@index');

$api->group(['middleware' => 'api.auth'], function ($api) {
	// Endpoints registered here will have the "foo" middleware applied.
});