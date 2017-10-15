<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class UserAuth
{
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
		
		$response = new Response();
		
		if(!$request->hasHeader('AuthenticationToken')) {

			$response->setContent(['error' => "No auth token found."]);
			$response->setStatusCode(400);
			return $response;
			
		}
		
        return $next($request);
    }
}
