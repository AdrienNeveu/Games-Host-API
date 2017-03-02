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

use App\Models\Game;
use App\Models\GameServer;
use App\Models\HostServer;
use App\Models\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    
    $hasher = app()->make('hash');
    
    return [
        'email'    => $faker->email,
        'password' => $hasher->make("secret"),
        'admin'    => true
    ];
});

$factory->state(User::class, 'non-admin', function ($faker) {
    return [
        'admin' => false,
    ];
});

$factory->define(HostServer::class, function (Faker\Generator $faker) {
    
    return [
        'name'      => $faker->safeColorName,
        'auth_info' => [
            'host'      => '127.0.0.1:22',
            'username'  => 'root',
            'password'  => '',
            'key'       => '',
            'keytext'   => '',
            'keyphrase' => '',
            'agent'     => '',
        ]
    ];
});

$factory->define(Game::class, function (Faker\Generator $faker) {
    
    return [
        'name'            => $faker->company,
        'short_name'      => $faker->colorName,
        'minplayers'      => $faker->numberBetween(1, 32),
        'maxplayers'      => $faker->numberBetween(32, 64),
        'cents_per_slots' => $faker->numberBetween(15, 35),
    ];
});

$factory->define(GameServer::class, function (Faker\Generator $faker) {
    
    if (User::count() == 0)
        factory(User::class)->create();
    if (Game::count() == 0)
        factory(Game::class)->create();
    if (HostServer::count() == 0)
        factory(HostServer::class)->create();
    
    return [
        'user_id'        => User::inRandomOrder()->first()->id,
        'game_id'        => Game::inRandomOrder()->first()->id,
        'host_server_id' => HostServer::inRandomOrder()->first()->id
    ];
});
