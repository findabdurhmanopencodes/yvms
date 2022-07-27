<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Woreda;
use Illuminate\Auth\Access\HandlesAuthorization;

class WoredaPolicy
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
        if ($user->hasPermissionTo('Woreda.index'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Woreda $woreda)
    {
        //
        if ($user->hasPermissionTo('Woreda.show'))
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
        if ($user->hasPermissionTo('Woreda.create'))
        return true;
    return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Woreda $woreda)
    {
        //
        if ($user->hasPermissionTo('Woreda.update'))
        return true;
    return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Woreda $woreda)
    {
        //
        if ($user->hasPermissionTo('Woreda.destroy'))
        return true;
    return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Woreda $woreda)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Woreda $woreda)
    {
        //
    }
}
