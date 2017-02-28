<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\ClientRepository;

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
    
    /**
     * Create user
     *
     * Creates a new user and returns its JSON representation.
     *
     * @Post("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"username": "john@doe.com", "password": "secret", "client_id": 5, "client_secret": "xxxx"}),
     *      @Response(201, headers={"Location": "/user"}),
     *      @Response(401, body={"message": "Unauthorized", "status_code": 401}),
     *      @Response(422, body={"message": "Could not create new user.", "status_code": 422, "errors": {"username": "The username field is required."}})
     * })
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'client_id' => 'required|integer',
            'client_secret' => 'required'
        ]);
        
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
        }
        
        $clientRepository = new ClientRepository();
        $client = $clientRepository->find($request->client_id);
        
        if ($client->secret !== $request->client_secret)
            throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException("Invalid Client credentials.");
        
        $user = new User;
        $user->email = $request->username;
        $user->password = app('hash')->make($request->password);
        $user->save();
        
        return $this->response->created("/user");
    }
}
