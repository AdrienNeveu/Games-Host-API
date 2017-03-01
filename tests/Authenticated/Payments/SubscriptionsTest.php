<?php

namespace Authenticated\User;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Stripe\Stripe;
use Stripe\Token;

class SubscriptionTest extends \TestCase
{
    
    use DatabaseMigrations;
    
    private $user = NULL;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
    
        Stripe::setApiKey(env("STRIPE_TEST_PUBLISHABLE_KEY"));
        
    }
    
    /*public function testSubscribeGameServer()
    {
        $this->be($this->user);
    
        $token = Token::create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 11,
                "exp_year" => 2050,
                "cvc" => "314"
            )
        ));
        dd($token);
    }*/
    
}
