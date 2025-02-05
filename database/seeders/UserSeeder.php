<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $user = User::query()->createOrFirst([
                'name' => 'Admin',
                'email' => 'admin@localhost',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'image' => 'https://randomuser.me/api/portraits/men/1.jpg',
            ]);
            $user2 = User::query()->createOrFirst([
                'name' => 'User',
                'email' => 'user@localhost',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'image' => 'https://randomuser.me/api/portraits/men/1.jpg',
            ]);
            $user2->assignRole('Author');

            $user->assignRole('Admin');
            User::factory(10)->create()->each(function ($user): void {
                $user->assignRole('Author');
            });
        } catch (\Exception) {
            // dd($e);
        }
    }
}
