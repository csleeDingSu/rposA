<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
class Reroute
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
		if (!Auth::Guard('member')->check())
		{
		//if(Auth::guest())
		//{
			//die('guest');
			Session::put('re_route','yes');
			return redirect('/login');
		}
		//die('imhere');
		return redirect('/arcade');
	}  
}
