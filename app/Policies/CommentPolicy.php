<?php

namespace App\Policies;

use App\Models\{Comment, User};

class CommentPolicy
{
    /**
     * Only authenticated users can create comments.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return (bool)$user;
    }

    /**
     * Authenticated users can update only their own comments.
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Authenticated users can delete only their own comments.
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment): bool
    {
        if ($user->id !== $comment->user_id) {
            return false;
        }

        return $comment->created_at->isAfter(now()->subHour());
    }
}
