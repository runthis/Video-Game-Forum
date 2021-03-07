<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Controllers\PostsController;
use App\Models\Posts;

class PostsFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Posts::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$subject = $this->faker->realText($this->faker->numberBetween(10, 150));

		$friendly_url = $this->friendly_url($subject);
		$link = $this->generate_link($friendly_url);

		return [
			'owner' => rand(1, 6),
			'ip' => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255),
			'subject' => $subject,
			'body' => $this->generate_paragraphs(rand(2, 5)),
			'sticky' => $this->should_sticky(),
			'link' => $link
		];
	}

	private function generate_paragraphs(int $length): string
	{
		$text = '';

		for ($i = 0; $i <= $length; $i++) {
			$text .= $this->faker->realText($this->faker->numberBetween(50, 300)) . str_repeat("\n", rand(0, 4));
		}

		return $text;
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

	private function should_sticky()
	{
		$random = rand(0, 100);

		if ($random > 90) {
			return true;
		}

		return false;
	}
}
