<?php

namespace Authenticated\OAuth;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\ClientRepository;

class OAuthTest extends \TestCase
{
    use DatabaseMigrations;
    
    
    private $client = NULL;
    private $user = NULL;
    private $authResponse = NULL;
    private $userResponse = NULL;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->authenticates();
    }
    
    private function authenticates()
    {
        $clientRepository = new ClientRepository();
        $this->client = $clientRepository->createPasswordGrantClient(NULL, "Test Application", "http://localhost");
        $this->user = factory(User::class)->create();
        
        $this->authResponse = $this->call('POST', '/oauth/token', [
            'grant_type'    => 'password',
            'scope'         => '*',
            'username'      => $this->user->email,
            'password'      => 'secret',
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret
        ]);
        $tokenContent = json_decode($this->authResponse->getContent(), true);
        $this->refreshApplication();
        $this->userResponse = $this->json('GET', 'user', [], ["Authorization" => "Bearer " . $tokenContent["access_token"]]);
    }
    
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
