<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Response;
use Closure;
use JWTAuth;
use Exception;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		
	    try {
		    JWTAuth::parseToken()->authenticate();
	    } catch (Exception $e) {
		    if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
			    return Response::err('Token is Invalid');

		    }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
			    return Response::err('Token is Expired');

		    }else{
			    return Response::err('Authorization Token not found');
		    }
	    }
	    return $next($request);
    }
}
