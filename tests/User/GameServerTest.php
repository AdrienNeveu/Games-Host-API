<?php

namespace Tests\User;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class GameServerTest extends \TestCase
{
    
    use DatabaseMigrations;
    
    private $user = NULL;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
    }
    
    public function testListGameServers()
    {
        $this->be($this->user);
        
        $gameserver = factory(\App\Models\GameServer::class)->create();
        $gameserver->user()->associate($this->user);
        $gameserver->save();
        
        $this->json('GET', 'user/gameservers')
            ->seeStatusCode(200)
            ->seeJson([
                'id' => $gameserver->id,
            ]);
    }
    
    public function testShowGameServer()
    {
        $this->be($this->user);
        
        $gameserver = factory(\App\Models\GameServer::class)->create();
        $gameserver->user()->associate($this->user);
        $gameserver->save();
        
        $this->json('GET', 'user/gameservers/' . $gameserver->id)
            ->seeStatusCode(200)
            ->seeJson([
                'id' => $gameserver->id,
            ]);
    }
    
    public function testShowGameServerNotFound()
    {
        $this->be($this->user);
        
        $this->json('GET', 'user/gameservers/999')
            ->seeStatusCode(404);
    }
    
}
