<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ActivitesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // instead of using regex you can use the function : title()
            'titre' => $this->faker->unique()->regexify('[A-Za-z0-9]{1,80}'),
            'description' => $this->faker->text(),
            'duree' => $this->faker->numberBetween(10),
            'difficulte' => $this->faker->numberBetween(1, 5),
            'age_max' => $this->faker->numberBetween(1, 15),
        ];
    }
}
