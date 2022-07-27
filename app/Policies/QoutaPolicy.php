<?php

namespace App\Policies;

use App\Models\Qouta;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QoutaPolicy
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
        if ($user->hasPermissionTo('Qouta.index'))
        return true;
    return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Qouta  $qouta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Qouta $qouta)
    {
        //
        if ($user->hasPermissionTo('Qouta.show'))
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
        //
        if ($user->hasPermissionTo('Qouta.create'))
        return true;
    return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Qouta  $qouta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Qouta $qouta)
    {
        //
        if ($user->hasPermissionTo('Qouta.update'))
        return true;
    return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Qouta  $qouta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Qouta $qouta)
    {
        //
        if ($user->hasPermissionTo('Qouta.destroy'))
        return true;
    return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Qouta  $qouta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Qouta $qouta)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Qouta  $qouta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Qouta $qouta)
    {
        //
    }
}
