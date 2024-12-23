<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\post;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Post $post): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Post $post): bool
    {
    }

    public function delete(User $user, Post $post): bool
    {
    }

    public function restore(User $user, Post $post): bool
    {
    }

    public function forceDelete(User $user, Post $post): bool
    {
    }
}
