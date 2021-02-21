<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
	public function __construct(User $user) {
		$this->user = $user;
    }
	
	public function register(array $data) {
		$this->user->name = $data['name'];
		$this->user->email = $data['email'];
		$this->user->password = Hash::make($data['password']);
		$this->user->save();
	}
	
	public function password_hash_match(string $password, string $hash): bool {
		return Hash::check($password, $hash);
    }
	
	public function user_data(string $email): array {
		return $this->user->first('email', $email);
    }
	
	public function email_exists(string $email) {
		return $this->user->exists('email', $email);
	}
}
