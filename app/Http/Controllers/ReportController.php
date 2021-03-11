<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Posts;
use App\Models\Reply;

class ReportController extends Controller
{
	/**
	 * Report a post
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	public function post(Request $request): void
	{
		$post = Posts::select('id', 'subject', 'body')->where('id', $request->post)->first();

		$report = Report::where([
			'owner' => $request->session()->get('forum.user'),
			'post' => $post->id
		])->first();

		if ($post && !$report) {
			Report::create([
				'owner' => $request->session()->get('forum.user'),
				'ip' => $request->ip(),
				'post' => $post->id,
				'subject' => $post->subject,
				'body' => $post->body
			]);
		}
	}

	/**
	 * Report a reply
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	public function reply(Request $request): void
	{
		$reply = Reply::select('id', 'post', 'body')->where('id', $request->reply)->first();
		$post = Posts::select('id', 'subject', 'body')->where('id', $reply->post)->first();

		$report = Report::where([
			'owner' => $request->session()->get('forum.user'),
			'post' => $post->id,
			'reply' => $reply->id
		])->first();

		if ($reply && !$report) {
			Report::create([
				'owner' => $request->session()->get('forum.user'),
				'ip' => $request->ip(),
				'post' => $post->id,
				'subject' => $post->subject,
				'body' => $post->body,
				'reply' => $reply->id,
				'reply_contents' => $reply->body
			]);
		}
	}
}
