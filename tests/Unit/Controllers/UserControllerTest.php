<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\UserController;
use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
	use WithFaker;

	public function setUp(): void
	{
		parent::setUp();
		$this->artisan('migrate');
	}

	public function test_can_register()
	{
		$model = User::factory()->make();
		$user = new UserController($model);

		$data = [
			'name' => $this->faker->name,
			'email' => $this->faker->unique()->safeEmail,
			'password' => $this->faker->password()
		];

		$user->register($data);

		$this->assertDatabaseHas('users', [
			'name' => $data['name'],
			'email' => $data['email']
		]);
	}

	public function test_can_password_hash_match()
	{
		$model = User::factory()->make();
		$user = new UserController($model);

		$password = 'password';
		$hash = '$2y$10$Mj4SpQHEHSWI9jOyA144RuhjM2XKt1H9qUuyf9MsMqZLhBqxHrnMq';

		$password_hash_match = $user->password_hash_match($password, $hash);

		$this->assertTrue($password_hash_match);
	}

	public function test_can_password_hash_not_match()
	{
		$model = User::factory()->make();
		$user = new UserController($model);

		$password = '2password';
		$hash = '$2y$10$Mj4SpQHEHSWI9jOyA144RuhjM2XKt1H9qUuyf9MsMqZLhBqxHrnMq';

		$password_hash_match = $user->password_hash_match($password, $hash);

		$this->assertFalse($password_hash_match);
	}

	public function test_can_get_user_data()
	{
		$email = $this->faker->unique()->safeEmail;
		$model = User::factory()->make([
			'email' => $email,
		]);

		$user = new UserController($model);

		$model->save();

		$user_data = $user->user_data($email);

		$this->assertArrayHasKey('email', $user_data);
		$this->assertEquals($email, $user_data['email']);
	}

	public function test_can_check_email_exists()
	{
		$email = $this->faker->unique()->safeEmail;
		$model = User::factory()->make([
			'email' => $email,
		]);
		$user = new UserController($model);

		$model->save();

		$email_exists = $user->email_exists($email);

		$this->assertTrue($email_exists);
	}

	public function test_can_check_email_doesnt_exist()
	{
		$model = User::factory()->make();
		$user = new UserController($model);

		$model->save();

		$email = $this->faker->unique()->safeEmail;
		$email_exists = $user->email_exists($email);

		$this->assertFalse($email_exists);
	}
}
