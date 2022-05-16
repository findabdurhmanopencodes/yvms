<?php

namespace App\Policies;

use App\Models\Disablity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DisablityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
        if ($user->hasPermissionTo('Disablity.index'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Disablity  $disablity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Disablity $disablity)
    {
        if ($user->hasPermissionTo('Disablity.show'))
            return true;
        return false;
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->hasPermissionTo('Disablity.create'))
            return true;
        return false;
        //

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Disablity  $disablity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Disablity $disablity)
    {
        //
        if ($user->hasPermissionTo('Disablity.update'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Disablity  $disablity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Disablity $disablity)
    {
        //
        if ($user->hasPermissionTo('Disablity.destroy'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Disablity  $disablity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Disablity $disablity)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Disablity  $disablity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Disablity $disablity)
    {
        //
    }
}
