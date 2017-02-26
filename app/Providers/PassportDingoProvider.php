<?php

namespace App\Providers;

use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;

class PassportDingoProvider extends Authorization
{
    public function authenticate(Request $request, Route $route)
    {
        return $request->user();
    }
    
    public function getAuthorizationMethod()
    {
        return 'bearer';
    }
}
