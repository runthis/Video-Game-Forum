<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use Session;

class PostsController extends Controller
{
	/**
	 * @var Posts
	 */
	private $posts;

	/**
	 * @param Posts $posts
	 */
	public function __construct(Posts $posts)
	{
		$this->posts = $posts;
	}

	public function create(Request $request)
	{
		$this->validate_create($request)->add_create($request);

		return redirect('/');
	}

	private function add_create(Request $request)
	{
		$this->posts->owner = $request->session()->get('forum.user');
		$this->posts->ip = $request->ip();
		$this->posts->subject = $request->subject;
		$this->posts->body = $request->body;
		$this->posts->save();
	}

	private function validate_create(Request $request)
	{
		$request->validate([
			'subject' => 'required|min:5|max:255',
			'body' => 'required|min:5|max:2048'
		]);

		return $this;
	}
}
