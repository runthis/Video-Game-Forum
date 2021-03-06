<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
		return [
			'owner' => rand(1, 6),
			'ip' => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255),
			'subject' => $this->faker->sentence,
			'body' => $this->faker->paragraph,
			'sticky' => $this->should_sticky()
		];
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
