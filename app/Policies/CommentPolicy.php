<?php

namespace App\Policies;

use App\Models\comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;

    }


    public function delete(User $user, comment $comment): bool
    {
        if ($user->id !== $comment->user_id)
            return false;
        return  $comment->created_at->isAfter(now()->subHour());
    }

    public function create()
    {
        return true;

    }

}
