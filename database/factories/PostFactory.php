<?php

namespace Database\Factories;

use App\Models\Community;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author' => fake()->name(),
            'title' => fake()->sentence(),
            'community_id' => $this->faker->randomElement(Community::pluck('id')),
            'description' => fake()->paragraph(5),
            'comments' => fake()->numberBetween(0, 100),
            'likes' => fake()->numberBetween(0, 100),
            'dislikes' => fake()->numberBetween(0, 100),
            'tags' => fake()->words(4, true),
        ];
    }
}
