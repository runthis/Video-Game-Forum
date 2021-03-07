<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use Session;

class PostsController extends Controller
{
	private $new_link = '/';

	public function create(Request $request)
	{
		$this->validate_create($request)->add_create($request);

		return redirect('/thread/' . $this->new_link);
	}

	public function get_posts(int $page = 1)
	{
		return Posts::select('id', 'owner', 'subject', 'link', 'sticky', 'created_at')->skip((($page - 1) * 10))->take(10)->orderBy('sticky', 'desc')->latest()->get();
	}

	public function get_single_post(string $link)
	{
		return Posts::select('id', 'owner', 'subject', 'body', 'link', 'sticky', 'created_at')->where('link', $link)->first();
	}

	public function get_posts_count()
	{
		return Posts::count();
	}

	private function add_create(Request $request)
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

	private function validate_create(Request $request)
	{
		$request->validate([
			'subject' => 'required|min:5|max:255',
			'body' => 'required|min:5|max:2048'
		]);

		return $this;
	}

	public function friendly_url(string $subject)
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

	public function generate_link(string $link)
	{
		$posts = Posts::where('link', $link);

		if (!$posts->exists()) {
			return $link;
		}

		$link = $link . rand(0, 9);

		return $this->generate_link($link);
	}
}
