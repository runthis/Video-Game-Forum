<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;

class ReplyController extends Controller
{
	public function create(Request $request)
	{
		Reply::create([
			'owner' => $request->session()->get('forum.user'),
			'ip' => $request->ip(),
			'post' => $request->post,
			'body' => $request->comment
		]);

		return redirect($request->url());
	}
}
