<?php

namespace Database\Factories;

use App\Models\User;
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
        $fakeColor = fake()->hexColor();
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'title' => fake()->sentence(),
            'community_id' => $this->faker->randomElement(Community::pluck('id')),
            'description' => fake()->paragraph(5),
            'comments' => fake()->numberBetween(0, 100),
            'likes' => fake()->numberBetween(0, 100),
            'dislikes' => fake()->numberBetween(0, 100),
            'views' => fake()->numberBetween(0, 100),
            'color' => $fakeColor,
            'textColor' => calculateTextColor($fakeColor),
            'tags' => fake()->words(4, true),
        ];
    }
}

// Calculate the text color based on the background color
function calculateTextColor($color) {
    list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
    $brightness = round(((intval($r) * 299) + (intval($g) * 587) + (intval($b) * 114)) / 1000);
    return ($brightness > 125) ? '#000000' : '#FFFFFF';
}