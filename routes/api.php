<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

$api->get('','App\Http\Controllers\API\Root@index');
$api->options('allows','App\Http\Controllers\API\Root@options');

$api->post('registration','App\Http\Controllers\API\Auth\User@register');
$api->get('token/request','App\Http\Controllers\API\Auth\Root@options');


$api->group(['prefix' => 'request'], function ($api) {
    $api->group(['prefix' => 'token'], function ($api) {
        $api->get('', 'App\Http\Controllers\API\Auth\Token@request');
        $api->post('', 'App\Http\Controllers\API\Auth\Token@request');
        $api->get('registered', 'App\Http\Controllers\API\Auth\Token@registered');
    });
});

$api->group(['middleware' => 'api.auth'], function ($api) {
	// Endpoints registered here will have the "foo" middleware applied.
});