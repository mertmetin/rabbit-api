<?php

namespace App\Policies;

use App\StripeCustomer;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StripeCustomerPolicy
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
     * @param  \App\StripeCustomer  $stripeCustomer
     * @return mixed
     */
    public function view(User $user, StripeCustomer $stripeCustomer)
    {
        return $user->id === $stripeCustomer->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\StripeCustomer  $stripeCustomer
     * @return mixed
     */
    public function update(User $user, StripeCustomer $stripeCustomer)
    {
        return $user->id === $stripeCustomer->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\StripeCustomer  $stripeCustomer
     * @return mixed
     */
    public function delete(User $user, StripeCustomer $stripeCustomer)
    {
        return $user->id === $stripeCustomer->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\StripeCustomer  $stripeCustomer
     * @return mixed
     */
    public function restore(User $user, StripeCustomer $stripeCustomer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\StripeCustomer  $stripeCustomer
     * @return mixed
     */
    public function forceDelete(User $user, StripeCustomer $stripeCustomer)
    {
        //
    }
}
