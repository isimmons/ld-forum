<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Anyone can view any posts.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Anyone can view any individual post.
     */
    public function view(?User $user, Post $post): bool
    {
        return true;
    }

    /**
     * For now, any authenticated user can create posts.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * A user can only update their own post.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * A user can only delete their own post.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
