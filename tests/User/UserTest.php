<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserTest extends \TestCase
{
    
    use DatabaseMigrations;
    
    private $user = NULL;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
    }
    
    public function testUserIndexAccessLoggedIn()
    {
        $this->be($this->user);
        
        $this->json('GET', 'user')
            ->seeStatusCode(200);
    }
    
    public function testUserIndexAccessLoggedOut()
    {
        $this->json('GET', 'user')
            ->seeStatusCode(401);
    }
    
    public function testUserIndexOutput()
    {
        $this->be($this->user);
        
        $this->json('GET', 'user')
            ->seeJsonStructure([
                'user' => [
                    'id',
                    'email',
                    'created_at'
                ]
            ]);
    }
    
}
