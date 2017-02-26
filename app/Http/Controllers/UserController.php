<?php

namespace App\Http\Controllers;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    use Helpers;
    
    public function __construct()
    {
    }
    
    public function index()
    {
        return $this->auth->user();
    }
}
