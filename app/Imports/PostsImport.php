<?php

namespace App\Imports;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PostsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (! Auth::check()) {
            return null; // Prevent import if user is not authenticated
        }

        $validator = Validator::make($row, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|unique:posts,slug',
            'blog image' => 'required|string',
            'Author ID' => ['required', Rule::exists('users', 'id')],
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed for row: '.json_encode($row).'. Errors: '.json_encode($validator->errors()));

            return null; // Validation failed, skip this row
        }

        try {
            $post = Post::create([
                'title' => $row['title'],
                'content' => $row['content'],
                'slug' => $row['slug'],
                'image' => $row['blog image'],
                'user_id' => $row['Author ID'],
            ]);

            Log::info('Post created successfully: '.$post->id);
        } catch (\Exception $e) {
            Log::error('Error creating post: '.$e->getMessage());
        }

        return $post;

    }
}
