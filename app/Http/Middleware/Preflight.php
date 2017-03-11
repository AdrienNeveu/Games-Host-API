<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Routing\Helpers;

class Preflight
{
    use Helpers;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $response = $next($request);
    
        if ($request->getMethod() == 'OPTIONS' && $response->getStatusCode() == 405) {
            return $this->response->noContent();
        }
    
        return $response;
    }
}
