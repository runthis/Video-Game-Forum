<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
	/**
	 * Register the user in the application
	 *
	 * @param Request $request
	 * @param UserController $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function register_user(Request $request, UserController $user): \Illuminate\Http\RedirectResponse
	{
		$request->validate([
			'name' => 'required|regex:/^[a-z0-9][a-z0-9_]*[a-z0-9]$/i',
			'email' => 'required|email',
			'password' => 'required|min:8',
			'confirm_password' => 'required|same:password'
		]);

		if ($user->email_exists($request->email)) {
			$request->session()->flash('register_status', 'The email address provided already exists.');

			return redirect('/register');
		}

		if ($user->name_exists($request->name)) {
			$request->session()->flash('register_status', 'The username provided already exists.');

			return redirect('/register');
		}

		$user->register($request->input());

		return redirect('/login');
	}

	/**
	 * Log the user in to the application
	 *
	 * @param Request $request
	 * @param UserController $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function login(Request $request, UserController $user): \Illuminate\Http\RedirectResponse
	{
		$request->validate([
			'email' => 'required|email',
			'password' => 'required'
		]);

		$user_data = $user->user_data($request->email);

		if (!$user->email_exists($request->email) || !$user->password_hash_match($request->password, $user_data['password'])) {
			$request->session()->flash('error', 'The email address or password is incorrect');

			return redirect('/login');
		}

		$request->session()->put('forum.user', $user_data['id']);
		$request->session()->put('forum.name', $user_data['name']);
		$request->session()->put('forum.lastAction', 'login');
		$request->session()->put('forum.lastActionTime', time());

		if ($request->session()->has('forum.lastPage')) {
			return redirect($request->session()->get('forum.lastPage'));
		}

		return redirect('/');
	}
}
