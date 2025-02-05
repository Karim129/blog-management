<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->sentence;

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'title' => $title,
            'content' => $this->faker->paragraphs(3, true),
            'image' => 'default.jpg',
            'slug' => $this->faker->unique()->slug,
        ];
    }
}
