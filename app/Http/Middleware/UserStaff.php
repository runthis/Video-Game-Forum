<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Closure;
use Session;

class UserStaff
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
		if (Session::get('forum.role') >= 2) {
			return $next($request);
		}

		return redirect('/login');
	}
}
