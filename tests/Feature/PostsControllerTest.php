<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PostsControllerTest extends TestCase
{
	use WithFaker;

	protected function setUp(): void
	{
		parent::setUp();
		$this->artisan('migrate');
	}

	public function test_can_add_post()
	{
		$data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$response = $this->withSession(['user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseHas('posts', ['subject' => $data['subject']]);
		$response->assertStatus(302);
		$response->assertRedirect(url()->getRequest()->getSchemeAndHttpHost());
	}

	public function test_can_not_add_short_post_subject()
	{
		$data = ['subject' => 'abc', 'body' => $this->faker->paragraph];
		$response = $this->withSession(['user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_short_post_body()
	{
		$data = ['subject' => 'abc', 'body' => $this->faker->paragraph];
		$response = $this->withSession(['user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_long_post_subject()
	{
		$data = ['subject' => implode(',', $this->faker->sentences(255)), 'body' => $this->faker->paragraph];
		$response = $this->withSession(['user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_long_post_body()
	{
		$data = ['subject' => $this->faker->sentence, 'body' => implode(',', $this->faker->paragraphs(50))];
		$response = $this->withSession(['user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_empty_post_data()
	{
		$data = ['subject' => '', 'body' => ''];
		$response = $this->withSession(['user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}
}
