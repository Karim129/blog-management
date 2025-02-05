<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any blog posts.
     */
    public function viewAny(User $user)
    {
        return $user->can('view all blog posts');
    }

    /**
     * Determine whether the user can view the blog post.
     */
    public function view(User $user, Post $post)
    {
        if ($user->can('view all blog posts')) {
            return true;
        }

        if ($user->can('view own blog posts') && $post->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create blog posts.
     */
    public function create(User $user)
    {
        return $user->can('create blog posts');
    }

    /**
     * Determine whether the user can update the blog post.
     */
    public function update(User $user, Post $post)
    {
        if ($user->can('edit blog posts') && $post->user_id === $user->id) {
            return true;
        }

        if ($user->can('edit blog posts') && $user->hasRole('Admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the blog post.
     */
    public function delete(User $user, Post $post)
    {
        if ($user->can('delete blog posts') && $post->user_id === $user->id) {
            return true;
        }

        if ($user->can('delete blog posts') && $user->hasRole('Admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can import blog posts.
     */
    public function import(User $user)
    {
        return $user->can('import blog posts');
    }

    /**
     * Determine whether the user can export blog posts.
     */
    public function export(User $user, ?Post $post = null)
    {
        if ($user->can('export all blog posts')) {
            return true;
        }

        if ($user->can('export own blog posts') && $post && $post->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
