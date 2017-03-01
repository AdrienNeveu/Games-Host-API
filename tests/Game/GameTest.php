<?php

namespace Authenticated\User;

use App\Models\Game;
use Laravel\Lumen\Testing\DatabaseMigrations;

class GameTest extends \TestCase
{
    
    use DatabaseMigrations;
    
    private $games = NULL;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->games = factory(Game::class, 5)->create();
    }
    
    public function testListGameSuccessful()
    {
        $this->json('GET', '/games')
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'games' => [
                    '*' => [
                        'id', 'name', 'short_name'
                    ]
                ]
            ]);
    }
    
    public function testShowGameSuccessful()
    {
        $game = $this->games->first();
        
        $this->json('GET', '/games/' . $game->id)
            ->seeStatusCode(200)
            ->seeJson([
                'id'         => $game->id,
                'name'       => $game->name,
                'short_name' => $game->short_name,
            ]);
    }
    
    public function testShowGameNotFound()
    {
        $this->json('GET', '/games/999')
            ->seeStatusCode(404);
    }
    
}
