<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Posts;

class PostSeeder extends Seeder
{
	use WithFaker;

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Posts::factory()->count(72)->create();
	}
}
