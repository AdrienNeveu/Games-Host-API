<?php

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Token;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Authentication management resource
 *
 * @Resource("Authentication", uri="/auth/token")
 */
class AuthController extends AccessTokenController
{
    use Helpers;
    
    
    /**
     * Code for OAuth authentication is located in dusterio\lumen-passport package.
     * This controller only serves as a wrapper for the documentation.
     */
    
    
    /**
     * Authenticates a user
     *
     * Authenticates a user and returns an Access Token, that should
     * be sent along any restricted endpoints in the `Authorization` header.
     *
     * @Post("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"grant_type": "password", "scope": "*", "username": "john@doe.com", "password": "secret", "client_id": 5, "client_secret": "xxx"}),
     *      @Response(200, body={"token_type":"Bearer", "expired_in": 31536000, "access_token": "xxx", "refresh_token": "xxx"}),
     *      @Response(401, body={"message": "Unauthorized", "status_code": 401})
     * })
     */
    public function issueToken(ServerRequestInterface $request)
    {
        return parent::issueToken($request);
    }
    
    /**
     * Revokes a user token access
     *
     * Revokes the user token access
     *
     * @Delete("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request(),
     *      @Response(200),
     *      @Response(401, body={"message": "Unauthorized", "status_code": 401})
     * })
     */
    public function revokeToken(Request $request)
    {
        foreach ($request->user()->tokens as $token)
        {
            $token->revoke();
        }
    }
}
