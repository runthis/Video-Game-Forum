<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Execute registration
	 *
	 * @param array $data
	 *
	 * @return void
	 */
	public function register(array $data): void
	{
		$this->user->name = $data['name'];
		$this->user->email = $data['email'];
		$this->user->password = Hash::make($data['password']);
		$this->user->save();
	}

	/**
	 * Confirm a users password is correct
	 *
	 * @param string $password
	 * @param string $hash
	 *
	 * @return boolean
	 */
	public function password_hash_match(string $password, string $hash): bool
	{
		return Hash::check($password, $hash);
	}

	/**
	 * Collect user data by email
	 *
	 * @param string $email
	 *
	 * @return array
	 */
	public function user_data(string $email): array
	{
		return $this->user->first('email', $email);
	}

	/**
	 * Check if email exists for user
	 *
	 * @param string $email
	 *
	 * @return boolean
	 */
	public function email_exists(string $email): bool
	{
		return $this->user->exists('email', $email);
	}
}
