<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

/**
 * User management resource
 *
 * @Resource("User", uri="/user")
 */
class UserController extends Controller
{
    
    use Helpers;
    
    public function __construct()
    {
    }
    
    /**
     * Show user
     *
     * Get a JSON representation of the current authenticated user.
     *
     * @Get("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request(headers={"Authorization": "Bearer AccessToken"}),
     *      @Response(200, body={"user": {"id": 10, "email": "john@doe.com", "created_at": "2017-02-27 16:48:21"}}),
     *      @Response(401, body={"message": "Unauthorized", "status_code": 401})
     * })
     */
    public function index()
    {
        return $this->auth->user();
    }
}
