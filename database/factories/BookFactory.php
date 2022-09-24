<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
	public function definition()
	{
		return [
			'title' => $this->faker->sentence(2),
			'author_id' => Author::factory(),
		];
	}
}
