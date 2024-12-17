<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api->group(['middleware' => 'api', 'limit' => 60, 'namespace' => 'App\Http\Controllers\API'], function ($api) {
    $api->get('', 'Root@index');
    $api->options('allows', 'Root@options');

    $api->group(['namespace' => 'Auth'], function ($api) {
        $api->post('accounts', 'User@request');

        $api->group(['prefix' => 'tokens'], function ($api) {
            $api->options('', 'Token@options');
            $api->post('', 'Token@request');
            $api->group(['middleware' => 'api.cv.auth'], function ($api) {
                $api->get('', 'Token@refresh');
            });
        });
    });
});
