<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\Response;

class VideoPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(User $user, Video $video): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Video $video): bool
    {
        return $user->id === $video->user_id;
    }

    public function delete(User $user, Video $video): bool
    {
        return $user->id === $video->user_id;
    }

    public function restore(User $user, Video $video): bool
    {
        return false;
    }

    public function forceDelete(User $user, Video $video): bool
    {
        return false;
    }
}
