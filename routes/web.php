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
    
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->group(['prefix' => 'token'], function ($api) {
            
            $api->post('/', 'App\Http\Controllers\Auth\AuthController@issueToken');
            
            $api->group(['middleware' => 'auth'], function ($api) {
                $api->delete('/', 'App\Http\Controllers\Auth\AuthController@revokeToken');
            });
        });
    });
    
    
    $api->group(['prefix' => 'user'], function ($api) {
        
        $api->post('/', 'App\Http\Controllers\User\UserController@store');
        
        $api->group(['middleware' => 'auth'], function ($api) {
            $api->get('/', 'App\Http\Controllers\User\UserController@index');
            
            $api->group(['prefix' => 'gameservers'], function ($api) {
                $api->get('/', 'App\Http\Controllers\User\GameServerController@index');
                $api->get('/{id}', 'App\Http\Controllers\User\GameServerController@show');
                $api->get('/{id}/start', 'App\Http\Controllers\User\GameServerController@start');
                $api->get('/{id}/stop', 'App\Http\Controllers\User\GameServerController@stop');
                $api->get('/{id}/restart', 'App\Http\Controllers\User\GameServerController@restart');
            });
        });
    });
    
    $api->group(['prefix' => 'hostservers'], function ($api) {
        
        $api->group(['middleware' => ['auth', 'admin']], function ($api) {
            $api->get('/', 'App\Http\Controllers\HostServers\HostServerController@index');
            $api->get('/{id}', 'App\Http\Controllers\HostServers\HostServerController@show');
        });
    });
    
    $api->group(['prefix' => 'games'], function ($api) {
        $api->get('/', 'App\Http\Controllers\Games\GameController@index');
        $api->get('/{id}', 'App\Http\Controllers\Games\GameController@show');
    });
    
});
