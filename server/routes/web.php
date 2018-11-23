<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'cliente'], function () use ($router) {
    $router->get('/', 'ClienteController@index');
    $router->get('/{client}', 'ClienteController@show');
    $router->post('/', 'ClienteController@store');
    $router->put('/{client}', 'ClienteController@update');
    $router->delete('/{client}', 'ClienteController@destroy');
});