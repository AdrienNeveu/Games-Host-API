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

use Carbon\Carbon;
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
        'ip'        => $faker->ipv4,
        'auth_info' => [
            'host'      => $faker->ipv4,
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
    
    $game = Game::inRandomOrder()->first();
    
    return [
        'user_id'        => User::inRandomOrder()->first()->id,
        'game_id'        => $game->id,
        'host_server_id' => HostServer::inRandomOrder()->first()->id,
        'players'        => $faker->numberBetween($game->minplayers, $game->maxplayers),
        'port'           => $faker->numberBetween(1111, 9999),
        'expires_at'     => Carbon::now()->addDays($faker->numberBetween(25, 100))->format('Y-m-d H:i:s'),
    ];
});
