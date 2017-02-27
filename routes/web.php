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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    
    $api->group(['middleware' => 'auth'], function ($api) {
        
        $api->get('user', 'App\Http\Controllers\UserController@index');
    });
    
    $api->post('auth/login', 'App\Http\Controllers\AuthController@issueToken');
});
