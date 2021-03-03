<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
	use WithFaker;

	protected function setUp(): void
	{
		parent::setUp();

		// Set up database
		$this->artisan('migrate');

		$this->email = $this->faker->unique()->safeEmail;
		$this->model = User::factory()->make([
			'email' => $this->email,
		]);
		$this->user = new UserController($this->model);
		$this->auth = new AuthController();
	}

	public function test_can_get_register()
	{
		$response = $this->get('/register');
		$response->assertStatus(200);
	}

	public function test_can_get_login()
	{
		$response = $this->get('/login');
		$response->assertStatus(200);
	}

	public function test_can_successfully_register()
	{
		$username = 'jsmith_88';
		$email = $this->faker->unique()->safeEmail;
		$password = $this->faker->password;
		$confirm_password = $password;

		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $username,
				'email' => $email,
				'password' => $password,
				'confirm_password' => $confirm_password,
			]
		);

		$expected_redirect = url()->getRequest()->getSchemeAndHttpHost() . '/register';

		$response->assertStatus(302);
		$response->assertRedirect($expected_redirect);
		$this->assertDatabaseHas('users', ['name' => $username]);
	}

	public function test_can_fail_register_with_bad_username()
	{
		$username = 'jsmith-88';
		$email = $this->faker->unique()->safeEmail;
		$password = $this->faker->password;
		$confirm_password = $password;

		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $username,
				'email' => $email,
				'password' => $password,
				'confirm_password' => $confirm_password,
			]
		);

		$this->assertDatabaseMissing('users', ['name' => $username]);
	}

	public function test_can_fail_register_with_bad_email()
	{
		$username = 'jsmith_88';
		$email = 'fake and bad';
		$password = $this->faker->password;
		$confirm_password = $password;

		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $username,
				'email' => $email,
				'password' => $password,
				'confirm_password' => $confirm_password,
			]
		);

		$this->assertDatabaseMissing('users', ['name' => $username]);
	}

	public function test_can_fail_register_with_non_matching_passwords()
	{
		$username = 'jsmith_88';
		$email = $this->faker->unique()->safeEmail;
		$password = $this->faker->password;
		$confirm_password = $this->faker->password;

		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $username,
				'email' => $email,
				'password' => $password,
				'confirm_password' => $confirm_password,
			]
		);

		$this->assertDatabaseMissing('users', ['name' => $username]);
	}

	public function test_can_fail_register_with_bad_everything()
	{
		$username = 'jsmith-88';
		$email = 'fake and bad';
		$password = $this->faker->password;
		$confirm_password = $this->faker->password;

		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $username,
				'email' => $email,
				'password' => $password,
				'confirm_password' => $confirm_password,
			]
		);

		$this->assertDatabaseMissing('users', ['name' => $username]);
	}

	/*

	'name' => 'required|regex:/^[a-z0-9][a-z0-9_]*[a-z0-9]$/i',
	'email' => 'required|email',
	'password' => 'required|min:8',
	'confirm_password' => 'required|same:password'



	public function test_can_register_user()
	{
		$request = new Request;

		$request->merge([
			'name' => 'longjohnson',
			'email' => $this->email,
			'password' => '123456780',
			'confirm_password' => '123456780'
		]);

		$this->auth->register_user($request, $this->user);

		//$expected = $this->user->email_exists($this->email);

		//$this->assertTrue($expected);
	}
*/
	/*
	public function test_cannot_register_user()
	{
		$this->model->save();

		$email = $this->faker->unique()->safeEmail;
		$expected = $this->user->email_exists($email);

		$this->assertFalse($expected);
	}

	public function test_can_login()
	{
		$request = new Request;

		$request->merge([
			'email' => $this->email,
			'password' => '123456780'
		]);

		$this->auth->login($request, $this->user);
	}

	public function test_can_get_home()
	{
		$this->get_page('/', 'Laravel v8.28.1');
	}

	public function test_can_get_register()
	{
		$this->get_page('/register', 'Forum - Register');
	}

	public function test_can_get_login()
	{
		$this->get_page('/login', 'Forum - Login');
	}

	private function get_page($page, $see)
	{
		$response = $this->get($page);

		$response->assertSuccessful();
		$response->assertSee($see);
	}
	*/
}
