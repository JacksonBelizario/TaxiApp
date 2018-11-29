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

$router->post('cliente/auth', 'ClienteController@auth');
$router->group(['prefix' => 'cliente', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'ClienteController@index');
    $router->get('/{cliente}', 'ClienteController@show');
    $router->post('/', 'ClienteController@store');
    $router->put('/{cliente}', 'ClienteController@update');
    $router->delete('/{cliente}', 'ClienteController@destroy');
});

$router->post('motorista/auth', 'MotoristaController@auth');
$router->group(['prefix' => 'motorista', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/', 'MotoristaController@index');
    $router->get('/{motorista}', 'MotoristaController@show');
    $router->post('/', 'MotoristaController@store');
    $router->put('/{motorista}', 'MotoristaController@update');
    $router->delete('/{motorista}', 'MotoristaController@destroy');
});