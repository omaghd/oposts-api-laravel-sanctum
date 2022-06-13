<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name'  => 'OmaghD',
            'email' => 'user@user'
        ]);

        Post::factory()->count(36)->create();

        // Categories without parent
        Category::create(['name' => 'Category 1', 'slug' => 'cat-1']);
        Category::create(['name' => 'Category 2', 'slug' => 'cat-2']);
        Category::create(['name' => 'Category 3', 'slug' => 'cat-3']);
        // Categories with random parent
        Category::factory()->count(24)->create();

        Tag::factory()->count(100)->create();

        Comment::factory()->count(150)->create();
    }
}
