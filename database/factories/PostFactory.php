<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
            'title'            => $this->faker->sentence(),
            'slug'             => $this->faker->slug(),
            'excerpt'          => $this->faker->sentence(),
            'body'             => $this->faker->paragraph(15),
            'cover'            => 'https://via.placeholder.com/1200x630',
            'status'           => $this->faker->randomElement(['draft', 'private', 'public']),
            'meta_title'       => $this->faker->sentence(),
            'meta_description' => $this->faker->paragraph(1),
            'meta_keywords'    => implode(',', explode(' ', $this->faker->sentence())),
            'published_at'     => $this->faker->dateTime(),
        ];
    }
}
