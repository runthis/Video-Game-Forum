<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Posts;
use App\Models\Reply;

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
		$data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$this->assertDatabaseHas('replies', ['body' => $data['comment']]);
	}

	public function test_can_not_add_reply_logged_out()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->post('/thread/' . $post->link, $data);

		$this->assertDatabaseMissing('replies', ['body' => $data['comment']]);
	}

	public function test_can_not_add_empty_reply()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id, 'comment' => ''];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$this->assertDatabaseMissing('replies', ['body' => $data['comment']]);
	}

	public function test_can_not_add_long_reply_body()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id, 'comment' => implode(',', $this->faker->paragraphs(50))];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$this->assertDatabaseMissing('replies', ['body' => $data['comment']]);
	}

	public function test_can_add_emoji_in_reply_body()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id, 'comment' => '💀😸😾🙈🐯'];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$this->assertDatabaseHas('replies', ['body' => $data['comment']]);
	}

	public function test_can_edit_reply()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where('post', $post->id)->first();
		$edit_data = ['reply' => $reply->id, 'link' => $post->link, 'replyBody' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 2])->post(route('replies.edit'), $edit_data);

		$this->assertDatabaseHas('replies', ['body' => $edit_data['replyBody']]);
	}

	public function test_can_not_edit_reply_wrong_user()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where('post', $post->id)->first();
		$edit_data = ['reply' => $reply->id, 'link' => $post->link, 'replyBody' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 1])->post(route('replies.edit'), $edit_data);

		// Assert that the body never changed
		$this->assertDatabaseHas('replies', ['body' => $reply->body]);
	}

	public function test_can_not_edit_reply_no_body()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where('post', $post->id)->first();
		$edit_data = ['reply' => $reply->id, 'link' => $post->link, 'replyBody' => ''];

		$this->withSession(['forum.user' => 2])->post(route('replies.edit'), $edit_data);

		// Assert that the body never changed
		$this->assertDatabaseHas('replies', ['body' => $reply->body]);
	}

	public function test_can_not_edit_reply_short_body()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where('post', $post->id)->first();
		$edit_data = ['reply' => $reply->id, 'link' => $post->link, 'replyBody' => 'abc'];

		$this->withSession(['forum.user' => 2])->post(route('replies.edit'), $edit_data);

		// Assert that the body never changed
		$this->assertDatabaseHas('replies', ['body' => $reply->body]);
	}

	public function test_can_not_edit_reply_long_body()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where('post', $post->id)->first();
		$edit_data = ['reply' => $reply->id, 'link' => $post->link, 'replyBody' => implode(',', $this->faker->paragraphs(50))];

		$this->withSession(['forum.user' => 2])->post(route('replies.edit'), $edit_data);

		// Assert that the body never changed
		$this->assertDatabaseHas('replies', ['body' => $reply->body]);
	}

	public function test_can_not_edit_reply_when_locked()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$lock_data = ['post' => $post->id];
		$this->withSession(['forum.user' => 2, 'forum.role' => 1])->post(route('posts.lock'), $lock_data);

		$reply = Reply::where('post', $post->id)->first();
		$edit_data = ['reply' => $reply->id, 'link' => $post->link, 'replyBody' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 1])->post(route('replies.edit'), $edit_data);

		// Assert that the body never changed
		$this->assertDatabaseHas('replies', ['body' => $reply->body]);
	}

	public function test_can_edit_reply_with_emoji()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$reply_data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $reply_data);

		$reply = Reply::where('post', $post->id)->first();
		$edit_data = ['reply' => $reply->id, 'link' => $post->link, 'replyBody' => '💀😸😾🙈🐯'];

		$this->withSession(['forum.user' => 2])->post(route('replies.edit'), $edit_data);

		$this->assertDatabaseHas('replies', ['body' => $edit_data['replyBody']]);
	}

	public function test_can_delete_reply()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$reply = Reply::where('post', $post->id)->first();
		$delete_data = ['reply' => $reply->id];

		$this->withSession(['forum.user' => 2])->post(route('replies.delete'), $delete_data);

		$this->assertSoftDeleted($reply);
	}

	public function test_can_not_delete_reply_with_wrong_user()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id, 'comment' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post('/thread/' . $post->link, $data);

		$reply = Reply::where('post', $post->id)->first();
		$delete_data = ['reply' => $reply->id];

		$this->withSession(['forum.user' => 1])->post(route('replies.delete'), $delete_data);

		$this->assertDatabaseHas('replies', ['id' => $reply->id]);
	}

	public function test_can_sticky_reply_as_post_owner()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id, 'comment' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 1])->post('/thread/' . $post->link, $data);

		$post = Posts::find(1);
		$sticky_data = ['reply' => $post->id];

		$this->withSession(['forum.user' => 2])->post(route('replies.sticky'), $sticky_data);

		$reply = Reply::where('post', $post->id)->first();

		$expected = 1;
		$reply_sticky = Reply::where('id', $reply->id)->first();

		$this->assertEquals($expected, $reply_sticky->sticky);
	}

	public function test_can_sticky_reply_as_staff()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id, 'comment' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 1])->post('/thread/' . $post->link, $data);

		$post = Posts::find(1);
		$sticky_data = ['reply' => $post->id];

		$this->withSession(['forum.user' => 3, 'forum.role' => 2])->post(route('replies.sticky'), $sticky_data);

		$reply = Reply::where('post', $post->id)->first();

		$expected = 1;
		$reply_sticky = Reply::where('id', $reply->id)->first();

		$this->assertEquals($expected, $reply_sticky->sticky);
	}

	public function test_can_not_sticky_reply_with_bad_role()
	{
		$post = Posts::find(1);
		$data = ['post' => $post->id, 'comment' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 1])->post('/thread/' . $post->link, $data);

		$post = Posts::find(1);
		$sticky_data = ['reply' => $post->id];

		$this->withSession(['forum.user' => 3, 'forum.role' => 1])->post(route('replies.sticky'), $sticky_data);

		$reply = Reply::where('post', $post->id)->first();

		$expected = 0;
		$reply_sticky = Reply::where('id', $reply->id)->first();

		$this->assertEquals($expected, $reply_sticky->sticky);
	}
}
