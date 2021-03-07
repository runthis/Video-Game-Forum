<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;

class ReplyController extends Controller
{
	/**
	 * Create a reply for a post
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function create(Request $request): \Illuminate\Http\RedirectResponse
	{
		$request->validate([
			'post' => 'required',
			'comment' => 'required|min:1|max:2048'
		]);

		Reply::create([
			'owner' => $request->session()->get('forum.user'),
			'ip' => $request->ip(),
			'post' => $request->post,
			'body' => $request->comment
		]);

		return redirect($request->url());
	}
}
