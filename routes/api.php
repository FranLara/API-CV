<?php
$api->group(['middleware' => 'api', 'limit' => 60], function ($api) {
	$api->get('', 'App\Http\Controllers\API\Root@index');
	$api->options('allows', 'App\Http\Controllers\API\Root@options');

	$api->post('token', 'App\Http\Controllers\API\Auth\Token@request');
	$api->post('account', 'App\Http\Controllers\API\Auth\User@request');

	$api->group(['middleware' => 'api.cv.auth'], function ($api) {
		$api->get('token', 'App\Http\Controllers\API\Auth\Token@refresh');
	});
});