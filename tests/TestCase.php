<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    
    protected $baseUrl = null;
    
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        $this->baseUrl = env('APP_URL', 'http://localhost');
        return require __DIR__.'/../bootstrap/app.php';
    }
}
