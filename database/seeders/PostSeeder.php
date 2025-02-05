<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please seed users first.');

            return;
        }

        foreach ($users as $user) {
            Post::factory()->count(5)->create([
                'user_id' => $user->id,
                'title' => 'Sample Post by '.$user->name,
                'content' => 'This is a sample content for '.$user->name,
                'slug' => Str::slug('Sample Post by '.$user->name.'-'.Str::random(5)),
                'image' => 'default.jpg', // Assuming a default image is available
            ]);
        }

    }
}
