<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Posts;
use App\Models\Reply;

class ReportControllerTest extends TestCase
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

	public function test_can_report_post()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id];

		$this->withSession(['forum.user' => 2])->post(route('reports.post'), $data);

		$this->assertDatabaseHas('reports', ['post' => $post->id]);
	}

	public function test_can_report_reply()
	{
		$post = Posts::find(1);
		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where('post', $post->id)->first();
		$reply_data = ['reply' => $reply->id];

		$this->withSession(['forum.user' => 2])->post(route('reports.reply'), $reply_data);

		$this->assertDatabaseHas('reports', ['reply' => $reply->id]);
	}

	public function test_can_not_report_post_no_user()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id];

		$this->post(route('reports.post'), $data);

		$this->assertDatabaseMissing('reports', ['post' => $post->id]);
	}

	public function test_can_not_report_reply_no_user()
	{
		$post = Posts::find(1);
		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where('post', $post->id)->first();
		$reply_data = ['reply' => $reply->id];

		$this->flushSession();

		$this->post(route('reports.reply'), $reply_data);

		$this->assertDatabaseMissing('reports', ['reply' => $reply->id]);
	}
}
