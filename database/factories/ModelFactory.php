<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    
    $hasher = app()->make('hash');
    
    return [
        'email'    => $faker->email,
        'password' => $hasher->make("secret"),
        'admin'    => true
    ];
});

$factory->state(App\Models\User::class, 'non-admin', function ($faker) {
    return [
        'admin' => false,
    ];
});

$factory->define(App\Models\HostServer::class, function (Faker\Generator $faker) {
    
    return [
        'name' => $faker->safeColorName,
        'ip'   => $faker->localIpv4
    ];
});
