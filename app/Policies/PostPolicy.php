<?php

namespace App\Policies;

use App\Models\{Post, User};

class PostPolicy
{
    /**
     * Anyone can view any posts.
     *
     * @param User|null $user
     * @return bool
     */
    public function viewAny(User|null $user): bool
    {
        return true;
    }

    /**
     * Anyone can view any individual post.
     *
     * @param User|null $user
     * @param Post $post
     * @return bool
     */
    public function view(User|null $user, Post $post): bool
    {
        return true;
    }

    /**
     * Any authenticated user can create posts.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return (bool)$user;
    }

    /**
     * A user can only update their own post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * A user can only delete their own post.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
