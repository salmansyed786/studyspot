<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'community_name' => fake()->word(),
            'about' => fake()->paragraph(5),
            'members' => fake()->numberBetween(0, 100),
            'posts' => fake()->numberBetween(0, 100),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
