<?php

namespace Authenticated;

use App\Models\User;
use Laravel\Passport\ClientRepository;

use TestCase;

abstract class AuthenticatedCase extends TestCase
{
    protected $client = null;
    protected $user = null;
    protected $authResponse = null;
    protected $userResponse = null;
    
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
}
