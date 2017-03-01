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
            
            $api->post('/', 'App\Http\Controllers\AuthController@issueToken');
            
            $api->group(['middleware' => 'auth'], function ($api) {
                $api->delete('/', 'App\Http\Controllers\AuthController@revokeToken');
            });
        });
    });
    
    
    $api->group(['prefix' => 'user'], function ($api) {
        
        $api->post('/', 'App\Http\Controllers\UserController@store');
        
        $api->group(['middleware' => 'auth'], function ($api) {
            $api->get('/', 'App\Http\Controllers\UserController@index');
        });
    });
    
    $api->group(['prefix' => 'hostservers'], function ($api) {
        
        $api->group(['middleware' => ['auth', 'admin']], function ($api) {
            $api->get('/', 'App\Http\Controllers\HostServerController@index');
            $api->get('/{id}', 'App\Http\Controllers\HostServerController@show');
        });
    });
    
    $api->group(['prefix' => 'games'], function ($api) {
        $api->get('/', 'App\Http\Controllers\GameController@index');
        $api->get('/{id}', 'App\Http\Controllers\GameController@show');
    });
    
});
