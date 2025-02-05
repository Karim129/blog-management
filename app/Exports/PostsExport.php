<?php

namespace App\Exports;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $query = Post::with('user');

        if (Auth::user()->role === 'Author') {
            $query->where('user_id', Auth::id());
        }

        return $query->get()->map(fn ($post): array => [
            'Title' => $post->title,
            'Content' => $post->content,
            'Author Name' => $post->user->name,
            'Created At' => $post->created_at->format('Y-m-d H:i:s'),
        ]);
    }

    public function headings(): array
    {
        return [
            'Title',
            'Content',
            'Author Name',
            'Created At',
        ];
    }
}
