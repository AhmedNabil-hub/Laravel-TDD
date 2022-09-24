<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
	public function definition()
	{
		return [
			'name' => $this->faker->name,
			'dob' => now()->format('m/d/Y'),
		];
	}
}
