<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class UserAuthenticated
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Closure  $request
	 * @return \Illuminate\Http\Response
	 */
	public function handle(\Illuminate\Http\Request $request, Closure $next)
	{
		if (!Session::get('user')) {
			return redirect('/login');
		}

		return $next($request);
	}
}
