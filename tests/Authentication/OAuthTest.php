<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\ClientRepository;

class OAuthTest extends \TestCase
{
    
    use DatabaseMigrations;
    
    public function testCreateClient()
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPasswordGrantClient(NULL, "Test Application", "http://localhost");
        
        $this->seeInDatabase('oauth_clients', ['secret' => $client->secret, 'id' => $client->id]);
    }
    
    
    public function testCreateUser()
    {
        $user = factory(User::class)->create();
        
        $this->seeInDatabase('users', ['email' => $user->email]);
    }
    
    /**
     * @depends testCreateUser
     * @depends testCreateClient
     */
    public function testAuthenticatesUser()
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPasswordGrantClient(NULL, "Test Application", "http://localhost");
        $user = factory(User::class)->create();
        
        $authResponse = $this->call('POST', '/auth/token', [
            'grant_type'    => 'password',
            'scope'         => '*',
            'username'      => $user->email,
            'password'      => 'secret',
            'client_id'     => $client->id,
            'client_secret' => $client->secret
        ]);
        
        $this->assertEquals(200, $authResponse->getStatusCode());
        $this->assertJson($authResponse->getContent());
    }
    
    /**
     * @depends testCreateUser
     * @depends testCreateClient
     */
    public function testAuthenticatesUserWrong()
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPasswordGrantClient(NULL, "Test Application", "http://localhost");
        
        $authResponse = $this->call('POST', '/auth/token', [
            'grant_type'    => 'password',
            'scope'         => '*',
            'username'      => "invalid@user.com",
            'password'      => 'invalid_password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret
        ]);
        
        $this->assertEquals(401, $authResponse->getStatusCode());
        $this->assertJson($authResponse->getContent());
    }
    
    /**
     * @depends testAuthenticatesUser
     */
    public function testAccessToken()
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPasswordGrantClient(NULL, "Test Application", "http://localhost");
        $user = factory(User::class)->create();
        
        $authResponse = $this->call('POST', '/auth/token', [
            'grant_type'    => 'password',
            'scope'         => '*',
            'username'      => $user->email,
            'password'      => 'secret',
            'client_id'     => $client->id,
            'client_secret' => $client->secret
        ]);
        
        $tokenContent = json_decode($authResponse->getContent(), true);
        $this->refreshApplication();
        
        $this->json('GET', 'user', [], ["Authorization" => "Bearer " . $tokenContent["access_token"]])
            ->seeStatusCode(200);
    }
    
    public function testLogout()
    {
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPasswordGrantClient(NULL, "Test Application", "http://localhost");
        $user = factory(User::class)->create();
        
        $authResponse = $this->call('POST', '/auth/token', [
            'grant_type'    => 'password',
            'scope'         => '*',
            'username'      => $user->email,
            'password'      => 'secret',
            'client_id'     => $client->id,
            'client_secret' => $client->secret
        ]);
        
        $tokenContent = json_decode($authResponse->getContent(), true);
        $this->refreshApplication();
        
        $this->json('DELETE', '/auth/token', [], ["Authorization" => "Bearer " . $tokenContent["access_token"]])
            ->seeStatusCode(200);
    
        $this->refreshApplication();
    
        $this->json('GET', 'user', [], ["Authorization" => "Bearer " . $tokenContent["access_token"]])
            ->seeStatusCode(401);
    }
}
