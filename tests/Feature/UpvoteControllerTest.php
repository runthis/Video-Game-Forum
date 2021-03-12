<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Posts;
use App\Models\Reply;
use App\Models\Vote;

class UpvoteControllerTest extends TestCase
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

	public function test_can_upvote_post()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id];

		$this->withSession(['forum.user' => 2])->post(route('votes.postup'), $data);

		$this->assertDatabaseHas('votes', ['post' => $post->id]);
		$this->assertDatabaseHas('votes', ['vote' => 1]);
	}

	public function test_can_downvote_post()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id];

		$this->withSession(['forum.user' => 2])->post(route('votes.postdown'), $data);

		$this->assertDatabaseHas('votes', ['post' => $post->id]);
		$this->assertDatabaseHas('votes', ['vote' => -1]);
	}

	public function test_can_un_upvote_post()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id];

		$this->withSession(['forum.user' => 2])->post(route('votes.postup'), $data);
		$this->withSession(['forum.user' => 2])->post(route('votes.postup'), $data);

		$vote = Vote::where(['post' => $post->id])->first();

		$this->assertSoftDeleted($vote);
	}

	public function test_can_un_downvote_post()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id];

		$this->withSession(['forum.user' => 2])->post(route('votes.postdown'), $data);
		$this->withSession(['forum.user' => 2])->post(route('votes.postdown'), $data);

		$vote = Vote::where(['post' => $post->id])->first();

		$this->assertSoftDeleted($vote);
	}

	public function test_can_upvote_reply()
	{
		$post = Posts::find(1);

		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where(['post' => $post->id])->first();
		$vote_data = ['reply' => $reply->id];

		$this->withSession(['forum.user' => 2])->post(route('votes.replyup'), $vote_data);

		$this->assertDatabaseHas('votes', ['reply' => $reply->id]);
		$this->assertDatabaseHas('votes', ['vote' => 1]);
	}

	public function test_can_downvote_reply()
	{
		$post = Posts::find(1);

		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where(['post' => $post->id])->first();
		$vote_data = ['reply' => $reply->id];

		$this->withSession(['forum.user' => 2])->post(route('votes.replydown'), $vote_data);

		$this->assertDatabaseHas('votes', ['reply' => $reply->id]);
		$this->assertDatabaseHas('votes', ['vote' => -1]);
	}

	public function test_can_un_upvote_reply()
	{
		$post = Posts::find(1);

		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where(['post' => $post->id])->first();
		$vote_data = ['reply' => $reply->id];

		$this->withSession(['forum.user' => 2])->post(route('votes.replyup'), $vote_data);
		$this->withSession(['forum.user' => 2])->post(route('votes.replyup'), $vote_data);

		$vote = Vote::where(['reply' => $reply->id])->first();

		$this->assertSoftDeleted($vote);
	}

	public function test_can_un_downvote_reply()
	{
		$post = Posts::find(1);

		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where(['post' => $post->id])->first();
		$vote_data = ['reply' => $reply->id];

		$this->withSession(['forum.user' => 2])->post(route('votes.replydown'), $vote_data);
		$this->withSession(['forum.user' => 2])->post(route('votes.replydown'), $vote_data);

		$vote = Vote::where(['reply' => $reply->id])->first();

		$this->assertSoftDeleted($vote);
	}

	public function test_can_not_upvote_post_with_no_user()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id];

		$this->post(route('votes.postup'), $data);

		$this->assertDatabaseMissing('votes', ['post' => $post->id]);
	}

	public function test_can_not_downvote_post_with_no_user()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id];

		$this->post(route('votes.postdown'), $data);

		$this->assertDatabaseMissing('votes', ['post' => $post->id]);
	}

	public function test_can_not_upvote_reply_with_no_user()
	{
		$post = Posts::find(1);

		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where(['post' => $post->id])->first();
		$vote_data = ['reply' => $reply->id];

		$this->flushSession();

		$this->post(route('votes.replyup'), $vote_data);

		$this->assertDatabaseMissing('votes', ['reply' => $reply->id]);
	}

	public function test_can_not_downvote_reply_with_no_user()
	{
		$post = Posts::find(1);

		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where(['post' => $post->id])->first();
		$vote_data = ['reply' => $reply->id];

		$this->flushSession();

		$this->post(route('votes.replydown'), $vote_data);

		$this->assertDatabaseMissing('votes', ['reply' => $reply->id]);
	}
}
