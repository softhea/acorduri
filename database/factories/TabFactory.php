<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tab>
 */
class TabFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(3, 10),
            'artist_id' => fake()->numberBetween(1, 20),
            'name' => fake()->name(),
            'no_of_chords' => fake()->numberBetween(0, 6),
            'no_of_views' => fake()->numberBetween(0, 2000),
        ];
    }
}
