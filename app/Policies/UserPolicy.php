<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    public function update(User $currentUser, User $user)
    {
        //当前用户只能修改自己的资料
        return $currentUser->id === $user->id;
    }
}
