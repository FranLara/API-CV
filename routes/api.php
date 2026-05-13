<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api->group(['middleware' => 'api', 'limit' => 60, 'namespace' => 'App\Http\Controllers\API'], function ($api) {
    $api->get('', 'Root@index');
    $api->options('allows', 'Root@options');

    $api->group(['prefix' => 'health'], function ($api) {
        $api->get('', 'Health@check');
        $api->options('', 'Health@options');
    });

    $api->group(['namespace' => 'Auth'], function ($api) {
        $api->group(['prefix' => 'accounts'], function ($api) {
            $api->post('', 'User@request');
            $api->group(['middleware' => 'api.cv.auth'], function ($api) {
                $api->patch('', 'User@update');
            });
        });

        $api->group(['prefix' => 'tokens'], function ($api) {
            $api->options('', 'Token@options');
            $api->post('', 'Token@request');
            $api->group(['middleware' => 'api.cv.auth'], function ($api) {
                $api->get('', 'Token@refresh');
            });
        });
    });
});
