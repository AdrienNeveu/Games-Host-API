<?php

namespace App\Providers;

class PassportServiceProvider extends \Dusterio\LumenPassport\PassportServiceProvider
{
    
    /**
     * We override registerRoutes() to disable registering Passport routes.
     * They are re-declared using Dingo API in /routes/web.php for more flexibility.
     */
    public function registerRoutes()
    {
    }
}
