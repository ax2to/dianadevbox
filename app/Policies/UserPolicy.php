<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User $user
     * @param  \App\User $user
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User $user
     * @param  \App\User $user
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User $user
     * @param  \App\User $user
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        //
    }

    public function changeRole(User $user)
    {

    }

    public function before(User $user)
    {
        return $user->isAdmin;
    }
}
