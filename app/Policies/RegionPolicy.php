<?php

namespace App\Policies;

use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegionPolicy
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
        if ($user->hasPermissionTo('Region.index'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Region $region)
    {
        //
        if ($user->hasPermissionTo('Region.show'))
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
        if ($user->hasPermissionTo('Region.create'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Region $region)
    {
        //
        if ($user->hasPermissionTo('Region.update'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Region $region)
    {
        //
        if ($user->hasPermissionTo('Region.destroy'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Region $region)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Region $region)
    {
        //
    }
    public function place(User $user, Region $region)
    {
        //
        if ($user->hasPermissionTo('Region.place'))
            return true;
        return false;
    }
}
