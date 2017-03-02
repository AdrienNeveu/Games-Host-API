<?php

namespace Tests\Payment;


use Laravel\Lumen\Testing\DatabaseMigrations;
use Swap\Laravel\Facades\Swap;

class PricingTest extends \TestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testSwapCurrencyRates()
    {
        $rate = Swap::latest(env('CURRENCY') . '/' . env('CURRENCY'));
    
        $this->assertEquals($rate->getValue(), 1);
    }
    
}
