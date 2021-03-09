<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Posts;

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
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseHas('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_post_logged_out()
	{
		$data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_short_post_subject()
	{
		$data = ['subject' => 'abc', 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_short_post_body()
	{
		$data = ['subject' => $this->faker->sentence, 'body' => 'abc'];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_long_post_subject()
	{
		$data = ['subject' => implode(',', $this->faker->sentences(255)), 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_long_post_body()
	{
		$data = ['subject' => $this->faker->sentence, 'body' => implode(',', $this->faker->paragraphs(50))];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_not_add_empty_post_data()
	{
		$data = ['subject' => '', 'body' => ''];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseMissing('posts', ['subject' => $data['subject']]);
	}

	public function test_can_add_emoji_subject()
	{
		$data = ['subject' => '💀😸😾🙈🐯', 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseHas('posts', ['subject' => $data['subject']]);
	}

	public function test_can_add_emoji_body()
	{
		$data = ['subject' => $this->faker->sentence, 'body' => '💀😸😾🙈🐯'];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $data);

		$this->assertDatabaseHas('posts', ['subject' => $data['subject']]);
	}

	public function test_can_edit_post()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$edit_data = ['post' => $post->id, 'link' => $post->link, 'body' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 2])->post(route('posts.edit'), $edit_data);

		$this->assertDatabaseHas('posts', ['body' => $edit_data['body']]);
	}

	public function test_can_not_edit_post_with_wrong_user()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$edit_data = ['post' => $post->id, 'link' => $post->link, 'body' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 1])->post(route('posts.edit'), $edit_data);

		$this->assertDatabaseMissing('posts', ['body' => $edit_data['body']]);
	}

	public function test_can_not_edit_post_with_no_body()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$edit_data = ['post' => $post->id, 'link' => $post->link, 'body' => ''];

		$this->withSession(['forum.user' => 2])->post(route('posts.edit'), $edit_data);

		$this->assertDatabaseMissing('posts', ['body' => $edit_data['body']]);
	}

	public function test_can_not_edit_post_with_short_body()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$edit_data = ['post' => $post->id, 'link' => $post->link, 'body' => 'abc'];

		$this->withSession(['forum.user' => 2])->post(route('posts.edit'), $edit_data);

		$this->assertDatabaseMissing('posts', ['body' => $edit_data['body']]);
	}

	public function test_can_not_edit_post_with_long_body()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$edit_data = ['post' => $post->id, 'link' => $post->link, 'body' => implode(',', $this->faker->paragraphs(50))];

		$this->withSession(['forum.user' => 2])->post(route('posts.edit'), $edit_data);

		$this->assertDatabaseMissing('posts', ['body' => $edit_data['body']]);
	}

	public function test_can_not_edit_post_with_bad_post()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$edit_data = ['post' => 12, 'link' => $post->link, 'body' => $this->faker->paragraph];

		$this->withSession(['forum.user' => 2])->post(route('posts.edit'), $edit_data);

		$this->assertDatabaseMissing('posts', ['body' => $edit_data['body']]);
	}

	public function test_can_delete_post()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$delete_data = ['post' => $post->id];

		$this->withSession(['forum.user' => 2])->post(route('posts.delete'), $delete_data);

		$this->assertSoftDeleted($post);
	}

	public function test_can_not_delete_post_with_wrong_user()
	{
		$post_data = ['subject' => $this->faker->sentence, 'body' => $this->faker->paragraph];
		$this->withSession(['forum.user' => 2])->post(route('posts.create'), $post_data);

		$post = Posts::find(1);
		$delete_data = ['post' => $post->id];

		$this->withSession(['forum.user' => 1])->post(route('posts.delete'), $delete_data);

		$this->assertDatabaseHas('posts', ['id' => $post->id]);
	}
}
