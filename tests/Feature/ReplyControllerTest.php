<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Posts;

class ReplyControllerTest extends TestCase
{
	use WithFaker;

	protected function setUp(): void
	{
		parent::setUp();
		$this->artisan('migrate');

		$data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $data);
		$this->flushSession();
	}

	public function test_can_add_reply()
	{
		$post = Posts::find(1);
		$data = ['post' => 1, 'comment' => $this->faker->paragraph];
		$response = $this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$this->assertDatabaseHas('replies', ['body' => $data['comment']]);
	}

	public function test_can_not_add_reply_logged_out()
	{
		$post = Posts::find(1);
		$data = ['post' => 1, 'comment' => $this->faker->paragraph];
		$response = $this->post('/thread/' . $post->link, $data);

		$this->assertDatabaseMissing('replies', ['body' => $data['comment']]);
	}

	public function test_can_not_add_empty_reply()
	{
		$post = Posts::find(1);
		$data = ['post' => 1, 'comment' => ''];
		$response = $this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$this->assertDatabaseMissing('replies', ['body' => $data['comment']]);
	}

	public function test_can_not_add_long_reply_body()
	{
		$post = Posts::find(1);
		$data = ['post' => 1, 'comment' => implode(',', $this->faker->paragraphs(50))];
		$response = $this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$this->assertDatabaseMissing('replies', ['body' => $data['comment']]);
	}

	public function test_can_add_emoji_in_reply_body()
	{
		$post = Posts::find(1);
		$data = ['post' => 1, 'comment' => '💀😸😾🙈🐯'];
		$response = $this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$this->assertDatabaseHas('replies', ['body' => $data['comment']]);
	}
}
