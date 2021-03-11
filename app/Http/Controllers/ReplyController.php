<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Posts;
use Session;

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

		$post = Posts::where('id', $request->post)->first();

		if ($post->lock == 0) {
			Reply::create([
				'owner' => $request->session()->get('forum.user'),
				'ip' => $request->ip(),
				'post' => $request->post,
				'body' => $request->comment
			]);
		}

		return redirect($request->url());
	}

	/**
	 * Set the body of a reply to a new value
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function edit(Request $request): \Illuminate\Http\RedirectResponse
	{
		$redirect = '/thread/' . $request->link . '/#thread-reply-' . $request->reply;
		$request->session()->flash('last_reply_edit', $request->reply);

		$validator = Validator::make($request->all(), [
			'replyBody' => 'required|min:5|max:2048'
		]);

		if ($validator->fails()) {
			return redirect($redirect)->withErrors($validator)->withInput();
		}

		$reply = Reply::select('owner', 'post')->where('id', $request->reply)->first();
		$post = Posts::where('id', $reply->post)->first();

		if ($post->lock == 0 && ($reply->owner == Session::get('forum.user') || Session::get('forum.role') > 1)) {
			Reply::where('id', $request->reply)->update(['body' => $request->replyBody]);
		}

		return redirect($redirect);
	}

	/**
	 * Delete a forum post reply
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	public function delete(Request $request): void
	{
		$reply = Reply::select('owner', 'post')->where('id', $request->reply)->first();
		$post = Posts::where('id', $reply->post)->first();

		if ($post->lock == 0 && ($reply->owner == Session::get('forum.user') || Session::get('forum.role') > 1)) {
			Reply::find($request->reply)->delete();
		}
	}

	/**
	 * Toggle a replies sticky
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	public function sticky(Request $request): void
	{
		$reply = Reply::select('owner', 'post', 'sticky')->where('id', $request->reply)->first();
		$post = Posts::where('id', $reply->post)->first();
		$sticky = ($reply->sticky == 0 ? 1 : 0);

		if (Session::get('forum.user') == $post->owner || Session::get('forum.role') > 1) {
			Reply::where('id', $request->reply)->update(['sticky' => $sticky]);
		}
	}
}
