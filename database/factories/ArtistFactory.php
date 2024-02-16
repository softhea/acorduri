<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
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
            'name' => fake()->name(),
            'no_of_tabs' => fake()->numberBetween(0, 20),
            'no_of_views' => fake()->numberBetween(0, 2000),
        ];
    }
}
