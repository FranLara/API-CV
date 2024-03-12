<?php

/*
 |--------------------------------------------------------------------------
 | API Routes
 |--------------------------------------------------------------------------
 */
$api->get('', 'App\Http\Controllers\API\Root@index');
$api->options('allows', 'App\Http\Controllers\API\Root@options');

$api->get('token', 'App\Http\Controllers\API\Auth\Token@request');

$api->post('account', 'App\Http\Controllers\API\Auth\User@request');

$api->group(['middleware' => 'api.auth'], function ($api) {
	// Endpoints registered here will have the "foo" middleware applied.
});