<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Passport\ClientRepository;

class AuthenticationTest extends TestCase
{
    
    private $client = null;
    private $user = null;
    private $authReponse = null;
    
    public function setUp()
    {
        parent::setUp();
        
        $clientRepository = new ClientRepository();
        $this->client = $clientRepository->createPasswordGrantClient(NULL, "Test Application", "http://localhost");
        $this->user = factory(User::class)->create();
        $this->authReponse = $this->call('POST', '/oauth/token', [
            'grant_type'    => 'password',
            'scope'         => '*',
            'username'      => $this->user->email,
            'password'      => 'secret',
            'client_id'     => $this->client->id,
            'client_secret' => $this->client->secret
        ]);
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
        $this->assertEquals(200, $this->authReponse->getStatusCode());
    }
}
