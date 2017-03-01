<?php

namespace App\Http\Controllers;

use App\Models\HostServer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

/**
 * HostServer management resource - A host server is the remote server that will host game servers.
 *
 * @Resource("HostServer", uri="/hostservers")
 */
class HostServerController extends Controller
{
    
    use Helpers;
    
    public function __construct()
    {
    }
    
    /**
     * Show the host servers list
     *
     *
     * Get a JSON representation of all host servers.
     *
     * *The user needs to be an administrator to access this endpoint*
     *
     * @Get("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request(headers={"Authorization": "Bearer AccessToken"}),
     *      @Response(200, body={"host_servers": {{"id": 10, "name": "Cthulhu", "ip": "192.168.0.1"}}}),
     *      @Response(401, body={"message": "Unauthorized", "status_code": 401})
     * })
     */
    public function index()
    {
        return HostServer::get();
    }
    
    /**
     * Show host server
     *
     *
     * Get a JSON representation of a host server represented by `id`.
     *
     * *The user needs to be an administrator to access this endpoint*
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="The ID of the hostserver.")
     * })
     * @Transaction({
     *      @Request(headers={"Authorization": "Bearer AccessToken"}),
     *      @Response(200, body={"host_server":{"id":1,"name":"Cthulhu","ip":"192.168.0.1"}}),
     *      @Response(401, body={"message": "Unauthorized", "status_code": 401}),
     *      @Response(404, body={"message": "Resource Not Found", "status_code": 404})
     * })
     */
    public function show($id)
    {
        $hostserver = HostServer::find($id);
        
        if (!$hostserver)
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Resource Not Found");
        
        return $hostserver;
    }
}
