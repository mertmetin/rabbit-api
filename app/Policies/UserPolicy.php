<?php

namespace App\Policies;

use App\User;
use App\UserAddress;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->id === Auth::user()->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\UserAddress  $userAddress
     * @return mixed
     */
    public function update(User $user, User $user2)
    {
        return $user->id === $user2->id;
    }

}
