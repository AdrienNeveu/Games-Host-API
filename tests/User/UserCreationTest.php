<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\ClientRepository;

class UserCreationTest extends \TestCase
{
    
    use DatabaseMigrations;
    
    private $client = NULL;
    
    public function setUp()
    {
        parent::setUp();
        
        $clientRepository = new ClientRepository();
        $this->client = $clientRepository->createPasswordGrantClient(NULL, "Test Application", "http://localhost");
    }
    
    
    public function testUserCreationSuccess()
    {

        $this->json('POST', 'user', [
            "client_id"     => $this->client->id,
            "client_secret" => $this->client->secret,
            "username"      => "john@doe.com",
            "password"      => "test_password"
        ])
            ->seeStatusCode(201);
    
        $this->seeInDatabase('users', ['email' => 'john@doe.com']);
    }
    
    public function testUsernameUniqueness()
    {
        $this->json('POST', 'user', [
            "client_id"     => $this->client->id,
            "client_secret" => $this->client->secret,
            "username"      => "john@doe.com",
            "password"      => "test_password"
        ])
            ->seeStatusCode(201);
    
        $this->json('POST', 'user', [
            "client_id"     => $this->client->id,
            "client_secret" => $this->client->secret,
            "username"      => "john@doe.com",
            "password"      => "test_password"
        ])
            ->seeStatusCode(422);
    }
    
    public function testEmailValidation()
    {
        $this->json('POST', 'user', [
            "client_id"     => $this->client->id,
            "client_secret" => $this->client->secret,
            "username"      => "test@email",
            "password"      => "test_password"
        ])
            ->seeStatusCode(422);
    }
    
}
