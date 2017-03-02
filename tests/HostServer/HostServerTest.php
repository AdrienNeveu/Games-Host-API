<?php

namespace Tests\HostServer;

use App\Models\HostServer;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class HostServerTest extends \TestCase
{
    
    use DatabaseMigrations;
    
    private $user = NULL;
    private $hostservers = NULL;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
        
        $this->hostservers = factory(HostServer::class, 5)->create();
    }
    
    public function testListHostServersSuccessful()
    {
        $this->be($this->user);
        
        $this->json('GET', '/hostservers')
            ->seeStatusCode(200)
            ->seeJsonStructure([
                'host_servers' => [
                    '*' => [
                        'id', 'name'
                    ]
                ]
            ]);
    }
    
    public function testListHostServersAsNonAdmin()
    {
        $this->be(factory(User::class)->states('non-admin')->make());
        
        $this->json('GET', '/hostservers')
            ->seeStatusCode(401);
    }
    
    public function testShowHostServerSuccessful()
    {
        $this->be($this->user);
        
        $hostserver = $this->hostservers->first();
        
        $this->json('GET', '/hostservers/' . $hostserver->id)
            ->seeStatusCode(200)
            ->seeJson([
                'id'   => $hostserver->id,
                'name' => $hostserver->name,
            ]);
    }
    
    public function testShowHostServerNotFound()
    {
        $this->be($this->user);
        
        $this->json('GET', '/hostservers/999')
            ->seeStatusCode(404);
    }
    
}
