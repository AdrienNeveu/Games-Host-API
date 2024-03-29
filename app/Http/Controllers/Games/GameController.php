<?php

namespace App\Http\Controllers\Games;

use App\Models\Game;
use App\Models\HostServer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

/**
 * Game management resource
 *
 * @Resource("Game", uri="/games")
 */
class GameController extends \App\Http\Controllers\Controller
{
    
    use Helpers;
    
    public function __construct()
    {
    }
    
    /**
     * Show the games list
     *
     *
     * Get a JSON representation of all available games.
     *
     * @Get("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Response(200, body={{"id": 10, "name": "Counter Strike Source", "shortname": "css", "minplayers": 5, "maxplayers": 64, "cents_per_slots": 25}}),
     * })
     */
    public function index()
    {
        return Game::where('disabled', false)->get()->all();
    }
    
    /**
     * Show a game
     *
     *
     * Get a JSON representation of a game represented by `id`.
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The ID of the game.")
     * })
     * @Transaction({
     *      @Response(200, body={"game":{"id": 10, "name": "Counter Strike Source", "shortname": "css", "minplayers": 5, "maxplayers": 64, "cents_per_slots": 25}}),
     *      @Response(404, body={"message": "Resource Not Found", "status_code": 404})
     * })
     */
    public function show($id)
    {
        $game = Game::find($id);
        
        if (!$game)
            return $this->response->errorNotFound("Resource Not Found");
    
        return $game->first();
    }
}
