<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use Session;

class PostsController extends Controller
{
	public function create(Request $request)
	{
		$this->validate_create($request)->add_create($request);

		return redirect('/');
	}

	public function get_posts(bool $sticky = false)
	{
		return Posts::select('id', 'owner', 'subject', 'created_at')->where('sticky', $sticky)->latest()->get();
	}

	private function add_create(Request $request)
	{
		Posts::create([
			'owner' => $request->session()->get('forum.user'),
			'ip' => $request->ip(),
			'subject' => $request->subject,
			'body' => $request->body,
		]);
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
