<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    echo 'test';
});


$router->get('/posts', ['uses' => 'PostController@index']);
$router->post('posts', ['uses' => 'PostController@store']);
$router->put('/post/{id}', ['uses' => 'PostController@update']);
$router->get('/post/{id}', ['uses' => 'PostController@show']);
$router->delete('post/{id}', ['uses' => 'PostController@destroy']);

$router->post('tags', ['uses' => 'TagController@store']);
$router->put('tag/{id}', ['uses' => 'TagController@update']);
$router->delete('tag/{id}', ['uses' => 'TagController@destroy']);

