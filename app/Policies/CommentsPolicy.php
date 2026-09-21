<?php

namespace App\Policies;

use App\Models\Comments;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentsPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Comments $comments): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Comments $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    public function delete(User $user, Comments $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    public function restore(User $user, Comments $comments): bool
    {
        return false;
    }

    public function forceDelete(User $user, Comments $comments): bool
    {
        return false;
    }
}
