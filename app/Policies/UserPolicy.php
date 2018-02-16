<?php

namespace App\Policies;

use App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if its creating first user.
     *
     * @param  \App\Entities\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return (User::count() == 0);
    }

    /**
     *  Determine if user can by updated by authorized admin
     *
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return ($user->isAdmin());
    }
}
