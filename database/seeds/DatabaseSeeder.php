<?php

use App\Models\HostServer;
use App\Models\User;
use App\Models\Game;
use App\Models\GameServer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Model
        DB::table('users')->delete();
        factory(User::class, 10)->create();
        User::first()->update(['email' => 'test@test.com']);
    
        // HostServer Model
        DB::table('host_servers')->delete();
        factory(HostServer::class, 5)->create();
    
        // Games Model
        DB::table('games')->delete();
        factory(Game::class, 5)->create();
    
        // GameServer Model
        DB::table('game_servers')->delete();
        factory(GameServer::class, 20)->create();
    }
}
