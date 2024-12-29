<?php

namespace App\Policies;

use App\Models\like;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class likePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, like $like): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, like $like): bool
    {
    }

    public function delete(User $user, like $like): bool
    {
    }

    public function restore(User $user, like $like): bool
    {
    }

    public function forceDelete(User $user, like $like): bool
    {
    }
}
