<?php

namespace App\Policies;

use App\StripeCard;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StripeCardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\StripeCard  $stripeCard
     * @return mixed
     */
    public function view(User $user, StripeCard $stripeCard)
    {
        return $user->id === $stripeCard->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\StripeCard  $stripeCard
     * @return mixed
     */
    public function update(User $user, StripeCard $stripeCard)
    {
        return $user->id === $stripeCard->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\StripeCard  $stripeCard
     * @return mixed
     */
    public function delete(User $user, StripeCard $stripeCard)
    {
        return $user->id === $stripeCard->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\StripeCard  $stripeCard
     * @return mixed
     */
    public function restore(User $user, StripeCard $stripeCard)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\StripeCard  $stripeCard
     * @return mixed
     */
    public function forceDelete(User $user, StripeCard $stripeCard)
    {
        //
    }
}
