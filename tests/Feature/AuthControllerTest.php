<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\UserController;
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
		$this->password = '1234567890';
		$this->name = 'jsmith_88';
		$this->model = User::factory()->make([
			'name' => $this->name,
			'email' => $this->email,
			'password' => $this->password,
		]);
		$this->user = new UserController($this->model);
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
		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $this->name,
				'email' => $this->email,
				'password' => $this->password,
				'confirm_password' => $this->password,
			]
		);

		$expected_redirect = url()->getRequest()->getSchemeAndHttpHost() . '/register';

		$response->assertStatus(302);
		$response->assertRedirect($expected_redirect);
		$this->assertDatabaseHas('users', ['name' => $this->name]);
	}

	public function test_can_fail_register_with_bad_username()
	{
		$username = 'jsmith-88';

		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $username,
				'email' => $this->email,
				'password' => $this->password,
				'confirm_password' => $this->password,
			]
		);

		$this->assertDatabaseMissing('users', ['name' => $username]);
	}

	public function test_can_fail_register_with_bad_email()
	{
		$email = 'fake and bad';

		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $this->name,
				'email' => $email,
				'password' => $this->password,
				'confirm_password' => $this->password,
			]
		);

		$this->assertDatabaseMissing('users', ['name' => $this->name]);
	}

	public function test_can_fail_register_with_non_matching_passwords()
	{
		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $this->name,
				'email' => $this->email,
				'password' => $this->password,
				'confirm_password' => $this->faker->password,
			]
		);

		$this->assertDatabaseMissing('users', ['name' => $this->name]);
	}

	public function test_can_fail_register_with_short_password()
	{
		$short_password = 'abc';

		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/registerUser',
			[
				'name' => $this->name,
				'email' => $this->email,
				'password' => $short_password,
				'confirm_password' => $short_password,
			]
		);

		$this->assertDatabaseMissing('users', ['name' => $this->name]);
	}

	public function test_can_successfully_login()
	{
		$this->model->save();
		$this->user->register(['name' => $this->name, 'email' => $this->email, 'password' => $this->password]);

		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/loginUser',
			[
				'email' => $this->email,
				'password' => $this->password
			]
		);

		$expected_redirect = url()->getRequest()->getSchemeAndHttpHost();

		$response->assertStatus(302);
		$response->assertRedirect($expected_redirect);
		$response->assertSessionHas('user');
	}

	public function test_can_fail_login()
	{
		$response = $this->withoutMiddleware('VerifyCsrfToken')->post(
			'/loginUser',
			[
				'email' => $this->email,
				'password' => $this->password
			]
		);

		$response->assertSessionMissing('user');
	}
}
