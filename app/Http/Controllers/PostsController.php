<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use Session;

class PostsController extends Controller
{
	/**
	 * The link to send the request to after a post has been made
	 *
	 * @var string
	 */
	private $new_link = '/';

	/**
	 * Validate and create a new post
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function create(Request $request): \Illuminate\Http\RedirectResponse
	{
		$this->validate_create($request)->add_create($request);

		return redirect('/thread/' . $this->new_link);
	}

	/**
	 * Get posts based on page
	 *
	 * @param integer $page
	 *
	 * @return object
	 */
	public function get_posts(int $page = 1): object
	{
		return Posts::select('id', 'owner', 'subject', 'link', 'sticky', 'lock', 'created_at')->skip((($page - 1) * 10))->take(10)->orderBy('sticky', 'desc')->latest()->get();
	}

	/**
	 * Get a single post
	 *
	 * @param string $link
	 *
	 * @return object
	 */
	public function get_single_post(string $link)
	{
		if ($this->link_exists($link)) {
			return Posts::select('id', 'owner', 'subject', 'body', 'link', 'sticky', 'lock', 'created_at')->where('link', $link)->first();
		}
	}

	/**
	 * Get a count of all posts
	 *
	 * @return integer
	 */
	public function get_posts_count(): int
	{
		return Posts::count();
	}

	/**
	 * Set the body of a post to a new value
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function edit(Request $request): \Illuminate\Http\RedirectResponse
	{
		$request->validate([
			'body' => 'required|min:5|max:2048'
		]);

		$post = Posts::select('owner')->where('id', $request->post)->first();

		if ($post->lock == 0 && ($post->owner == Session::get('forum.user') || Session::get('forum.role') > 1)) {
			Posts::where('id', $request->post)->update(['body' => $request->body]);
		}

		return redirect('/thread/' . $request->link);
	}

	/**
	 * Delete a forum post
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	public function delete(Request $request): void
	{
		$post = Posts::select('owner')->where('id', $request->post)->first();

		if ($post->lock == 0 && ($post->owner == Session::get('forum.user') || Session::get('forum.role') > 1)) {
			Posts::find($request->post)->delete();
		}
	}

	/**
	 * Check if a forum post link exists
	 *
	 * @param string $link
	 *
	 * @return boolean
	 */
	private function link_exists(string $link): bool
	{
		$post = Posts::where('link', $link);

		if ($post) {
			return true;
		}

		return false;
	}

	/**
	 * Add the new post to the database
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	private function add_create(Request $request): void
	{
		$friendly_url = $this->friendly_url($request->subject);
		$this->new_link = $this->generate_link($friendly_url);

		Posts::create([
			'owner' => $request->session()->get('forum.user'),
			'ip' => $request->ip(),
			'subject' => $request->subject,
			'body' => $request->body,
			'link' => $this->new_link
		]);
	}

	/**
	 * Validate a post request
	 *
	 * @param Request $request
	 *
	 * @return PostsController
	 */
	private function validate_create(Request $request): PostsController
	{
		$request->validate([
			'subject' => 'required|min:5|max:255',
			'body' => 'required|min:5|max:2048'
		]);

		return $this;
	}

	/**
	 * Generate a friendly url by post subject
	 *
	 * @param string $subject
	 *
	 * @return string
	 */
	public function friendly_url(string $subject): string
	{
		$url = strtolower(trim($subject));
		$url = preg_replace('/[^\p{L}\p{N}]+/', '-', $url);
		$url = preg_replace("/\x{FFFD}/u", '', $url);
		$url = substr($url, 0, 44);

		if (strlen($url) < 5) {
			$url = 'posts';
		}

		return $url;
	}

	/**
	 * Generate a link for a post
	 *
	 * @param string $link
	 *
	 * @return string
	 */
	public function generate_link(string $link): string
	{
		$posts = Posts::where('link', $link);

		if (!$posts->exists()) {
			return $link;
		}

		$link = $link . rand(0, 9);

		return $this->generate_link($link);
	}

	/**
	 * Toggle a posts sticky
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	public function sticky(Request $request): void
	{
		$post = Posts::where('id', $request->post)->first();
		$sticky = ($post->sticky == 0 ? 1 : 0);

		if (Session::get('forum.role') > 1) {
			Posts::where('id', $request->post)->update(['sticky' => $sticky]);
		}
	}

	/**
	 * Toggle a posts lock status
	 *
	 * @param Request $request
	 *
	 * @return void
	 */
	public function lock(Request $request): void
	{
		$post = Posts::where('id', $request->post)->first();
		$lock = ($post->lock == 0 ? 1 : 0);

		if (Session::get('forum.role') > 1) {
			Posts::where('id', $request->post)->update(['lock' => $lock]);
		}
	}
}
