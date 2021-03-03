<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\PostsController;

class PostsControllerTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		$this->posts = new PostsController;
	}

	public function test_create()
	{
		$expected = 'PostsController.create';
		$response = $this->posts->create();

		$this->assertEquals($expected, $response);
	}
}
