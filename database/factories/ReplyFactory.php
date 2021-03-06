<?php

namespace Database\Factories;

use App\Models\Reply;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Reply::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'owner' => rand(1, 6),
			'ip' => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255),
			'post' => rand(1, 72),
			'body' => $this->generate_paragraphs(rand(2, 5)),
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
}
