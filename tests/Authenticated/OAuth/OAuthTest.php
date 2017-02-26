<?php

namespace Authenticated\OAuth;

use Authenticated\AuthenticatedCase;

class OAuthTest extends AuthenticatedCase
{
    public function testCreateClient()
    {
        $this->seeInDatabase('oauth_clients', ['secret' => $this->client->secret, 'id' => $this->client->id]);
    }
    
    public function testCreateUser()
    {
        $this->seeInDatabase('users', ['email' => $this->user->email]);
    }
    
    public function testAuthenticatesUser()
    {
        $this->assertEquals(200, $this->authResponse->getStatusCode());
        $this->assertJson($this->authResponse->getContent());
    }
    
    /**
     * @depends testAuthenticatesUser
     */
    public function testAccessToken()
    {
        $this->userResponse->seeStatusCode(200);
    }
}
