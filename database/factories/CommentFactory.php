<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'       => $this->faker->name(),
            'phone'      => $this->faker->phoneNumber(),
            'email'      => $this->faker->email(),
            'ip'         => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'body'       => $this->faker->paragraph(3),
            'status'     => rand(0, 1),
            'post_id'    => Post::all()->random()->id,
        ];
    }
}
