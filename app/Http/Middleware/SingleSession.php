<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
class SingleSession
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
		if (Auth::Guard('member')->check())
		{
		   // If current session id is not same with last_session column
		   if(Auth::guard('member')->user()->active_session != Session::getId())
		   {
			  // do logout
			   Auth::Guard('member')->logout();
			  // Redirecto login page
			   return redirect( '/login' );
		   }
		}
		return $next($request);
    }
}
