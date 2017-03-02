<?php

namespace App\Http\Controllers\User;

use App\Models\GameServer;
use Dingo\Api\Routing\Helpers;

/**
 * User's game servers management resource
 *
 * @Resource("User's GameServers", uri="/user/gameservers")
 */
class GameServerController extends \App\Http\Controllers\Controller
{
    
    use Helpers;
    
    public function __construct()
    {
    }
    
    /**
     * Show the user's game servers list
     *
     * Get a JSON representation of the list of game servers owned by the user.
     *
     * @Get("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request(headers={"Authorization": "Bearer AccessToken"}),
     *      @Response(200, body={{"id":8,"user_id":8,"game_id":1,"host_server_id":1,"installed":2,"created_at":"2017-03-02 20:33:44","updated_at":"2017-03-02 20:33:44","game":{"id":1,"name":"Counter Strike : Source","short_name":"css","minplayers":25,"maxplayers":64,"cents_per_slots":20},"hostserver":{"id":1,"name":"Cthulhu"}}}),
     *      @Response(401, body={"message": "Unauthorized", "status_code": 401})
     * })
     */
    public function index()
    {
        return $this->auth->user()->gameServers()->with("game", "hostserver")->get()->all();
    }
    
    /**
     * Show a user's game server
     *
     *
     * Get a JSON representation of a user's game server represented by `id`.
     *
     * *The user needs to own the game server to access this endpoint*
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The ID of the hostserver.")
     * })
     * @Transaction({
     *      @Request(headers={"Authorization": "Bearer AccessToken"}),
     *      @Response(200, body={"game_server":{"id":1,"user_id":1,"game_id":1,"host_server_id":1,"installed":2,"created_at":"2017-03-02 20:56:27","updated_at":"2017-03-02 20:56:27","game":{"id":1,"name":"Counter Strike : Source","short_name":"css","minplayers":16,"maxplayers":54,"cents_per_slots":34},"hostserver":{"id":1,"name":"Cthulhu"}}}),
     *      @Response(401, body={"message": "Unauthorized", "status_code": 401}),
     *      @Response(404, body={"message": "Resource Not Found", "status_code": 404})
     * })
     */
    public function show($id)
    {
        $hostserver = GameServer::where([
            'id' => $id,
            'user_id' => $this->auth->user()->id
        ])->with("game", "hostserver")->first();
        
        if (!$hostserver)
            return $this->response->errorNotFound("Resource Not Found");
        
        return $hostserver;
    }
}
