<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;

class VoteController extends Controller
{
	/**
	 * Upvote a post
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function postup(Request $request): array
	{
		$return = [];

		$upvote = Vote::where([
			'owner' => $request->session()->get('forum.user'),
			'vote' => 1,
			'post' => $request->post
		]);

		if ($upvote->first()) {
			$upvote->delete();

			return [
				'status' => 'deleted',
				'votes' => Vote::where(['post' => $request->post])->sum('vote')
			];
		} else {
			$this->delete($request, 'post');

			Vote::create([
				'owner' => $request->session()->get('forum.user'),
				'vote' => 1,
				'post' => $request->post
			]);

			return [
				'status' => 'created',
				'votes' => Vote::where(['post' => $request->post])->sum('vote')
			];
		}
	}

	/**
	 * Downvote a post
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function postdown(Request $request): array
	{
		$return = [];

		$downvote = Vote::where([
			'owner' => $request->session()->get('forum.user'),
			'vote' => -1,
			'post' => $request->post
		]);

		if ($downvote->first()) {
			$downvote->delete();

			return [
				'status' => 'deleted',
				'votes' => Vote::where(['post' => $request->post])->sum('vote')
			];
		} else {
			$this->delete($request, 'post');

			Vote::create([
				'owner' => $request->session()->get('forum.user'),
				'vote' => -1,
				'post' => $request->post
			]);

			return [
				'status' => 'created',
				'votes' => Vote::where(['post' => $request->post])->sum('vote')
			];
		}
	}

	/**
	 * Upvote a reply
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function replyup(Request $request): array
	{
		$return = [];

		$upvote = Vote::where([
			'owner' => $request->session()->get('forum.user'),
			'vote' => 1,
			'reply' => $request->reply
		]);

		if ($upvote->first()) {
			$upvote->delete();

			return [
				'status' => 'deleted',
				'votes' => Vote::where(['reply' => $request->reply])->sum('vote')
			];
		} else {
			$this->delete($request, 'reply');

			Vote::create([
				'owner' => $request->session()->get('forum.user'),
				'vote' => 1,
				'reply' => $request->reply
			]);

			return [
				'status' => 'created',
				'votes' => Vote::where(['reply' => $request->reply])->sum('vote')
			];
		}
	}

	/**
	 * Downvote a reply
	 *
	 * @param Request $request
	 *
	 * @return array
	 */
	public function replydown(Request $request): array
	{
		$return = [];

		$downvote = Vote::where([
			'owner' => $request->session()->get('forum.user'),
			'vote' => -1,
			'reply' => $request->reply
		]);

		if ($downvote->first()) {
			$downvote->delete();

			return [
				'status' => 'deleted',
				'votes' => Vote::where(['reply' => $request->reply])->sum('vote')
			];
		} else {
			$this->delete($request, 'reply');

			Vote::create([
				'owner' => $request->session()->get('forum.user'),
				'vote' => -1,
				'reply' => $request->reply
			]);

			return [
				'status' => 'created',
				'votes' => Vote::where(['reply' => $request->reply])->sum('vote')
			];
		}
	}

	/**
	 * Delete all votes by an owner and by type
	 *
	 * @param Request $request
	 * @param string $type
	 *
	 * @return void
	 */
	public function delete(Request $request, string $type): void
	{
		Vote::where([
			'owner' => $request->session()->get('forum.user'),
			$type => $request->{$type}
		])->delete();
	}
}
