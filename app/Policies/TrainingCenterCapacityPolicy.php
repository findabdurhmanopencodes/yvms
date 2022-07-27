<?php

namespace App\Policies;

use App\Models\TrainingCenterCapacity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainingCenterCapacityPolicy
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
        if ($user->hasPermissionTo('TrainingCenterCapacity.index'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrainingCenterCapacity  $trainingCenterCapacity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TrainingCenterCapacity $trainingCenterCapacity)
    {
        //
        if ($user->hasPermissionTo('TrainingCenterCapacity.show'))
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
        if ($user->hasPermissionTo('TrainingCenterCapacity.create'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrainingCenterCapacity  $trainingCenterCapacity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TrainingCenterCapacity $trainingCenterCapacity)
    {
        //
        if ($user->hasPermissionTo('TrainingCenterCapacity.update'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrainingCenterCapacity  $trainingCenterCapacity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TrainingCenterCapacity $trainingCenterCapacity)
    {
        //
        if ($user->hasPermissionTo('TrainingCenterCapacity.destroy'))
            return true;
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrainingCenterCapacity  $trainingCenterCapacity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TrainingCenterCapacity $trainingCenterCapacity)
    {
        //

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TrainingCenterCapacity  $trainingCenterCapacity
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TrainingCenterCapacity $trainingCenterCapacity)
    {
        //
    }
}
