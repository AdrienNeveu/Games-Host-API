<?php

namespace Tests\GameServer;


use App\Models\Game;
use App\Models\GameServer;
use App\Models\HostServer;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class GameServerTest extends \TestCase
{
    
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testModelsRelationships()
    {
        $user = factory(User::class)->create();
        $game = factory(Game::class)->create();
        $hostServer = factory(HostServer::class)->create();
        
        $gameServer = new GameServer;
        $gameServer->user()->associate($user);
        $gameServer->game()->associate($game);
        $gameServer->hostServer()->associate($hostServer);
        $gameServer->save();
        
        // User
        $this->assertEquals($gameServer->user->id, $user->id);
        $this->assertEquals($user->gameServers[0]->id, $gameServer->id);
        
        // Game
        $this->assertEquals($gameServer->game->id, $game->id);
        $this->assertEquals($game->gameServers[0]->id, $gameServer->id);
        
        // HostServers
        $this->assertEquals($gameServer->hostServer->id, $hostServer->id);
        $this->assertEquals($hostServer->gameServers[0]->id, $gameServer->id);
    
    
    }
}
