<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Auth\Access\HandlesAuthorization;

class VolunteerPolicy
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
        if ($user->hasPermissionTo('Volunteer.index'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Volunteer $volunteer)
    {
        //
        //
        if ($user->hasPermissionTo('Volunteer.show'))
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
        //
        if ($user->hasPermissionTo('Volunteer.create'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Volunteer $volunteer)
    {
        //
        //
        if ($user->hasPermissionTo('Volunteer.update'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Volunteer $volunteer)
    {
        //
        //
        if ($user->hasPermissionTo('Volunteer.destroy'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Volunteer $volunteer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Volunteer $volunteer)
    {
        //
    }
}
