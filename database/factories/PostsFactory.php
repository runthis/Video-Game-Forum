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
		$subject = $this->faker->sentence;

		$friendly_url = $this->friendly_url($subject);
		$link = $this->generate_link($friendly_url);

		return [
			'owner' => rand(1, 6),
			'ip' => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255),
			'subject' => $subject,
			'body' => implode(str_repeat("\n", rand(1, 9)), $this->faker->paragraphs(rand(1, 9))),
			'sticky' => $this->should_sticky(),
			'link' => $link
		];
	}

	public function friendly_url(string $subject)
	{
		$url = strtolower(trim($subject));
		$url = preg_replace('/[^\p{L}\p{N}]+/', '-', $url);
		$url = substr($url, 0, 44);

		return $url;
	}

	public function generate_link(string $link)
	{
		if (Posts::where('link', $link)->exists()) {
			$link = $link . '-' . mt_rand(0, 9);

			return $this->generate_link($link);
		}

		return $link;
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
