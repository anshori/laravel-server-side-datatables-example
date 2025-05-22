<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PersonModelFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name' => $this->faker->unique()->name(),
			'email' => $this->faker->unique()->safeEmail(),
			'hometown' => $this->faker->city(),
			'city' => $this->faker->city(),
			'state' => $this->faker->state(),
			'company' => $this->faker->company(),
			// latitude ymin = -7.80068 & ymax = -6.95783
			'latitude' => $this->faker->latitude(-7.80068, -6.95783),
			// longitude xmin = 109.60510 & xmax = 111.36292
			'longitude' => $this->faker->longitude(109.60510, 111.36292),
		];
	}
}
