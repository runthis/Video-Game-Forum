<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posts;

class PostSeeder extends Seeder
{
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
