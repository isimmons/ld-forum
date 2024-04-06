<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can create comments
     * Any user can create a comment
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the comment
     * A user can only update their own comment
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the comment
     * A user can only delete their own comment
     */
    public function delete(User $user, Comment $comment): bool
    {
        if($user->id !== $comment->user_id) return false;

        return $comment->created_at->isAfter(now()->subHour());
    }
}
