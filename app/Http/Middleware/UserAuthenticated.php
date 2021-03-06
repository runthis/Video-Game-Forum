<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
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
		if (!Session::get('forum.user')) {
			$current_route = Route::getFacadeRoot()->current()->uri();
			$forum_lastPage = '/';

			switch ($current_route) {
				case 'posts.create': case 'post':
					$forum_lastPage = route('post');
				break;
			}

			$request->session()->put('forum.lastPage', $forum_lastPage);

			return redirect('/login');
		}

		return $next($request);
	}
}
