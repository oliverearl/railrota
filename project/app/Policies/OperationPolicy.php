<?php

namespace App\Policies;

use App\User;
use App\Operation;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class OperationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any operations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the operation.
     *
     * @param  \App\User  $user
     * @param  \App\Operation  $operation
     * @return mixed
     */
    public function view(User $user, Operation $operation)
    {
        //
    }

    /**
     * Determine whether the user can create operations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::id()->isAdmin();
    }

    /**
     * Determine whether the user can update the operation.
     *
     * @param  \App\User  $user
     * @param  \App\Operation  $operation
     * @return mixed
     */
    public function update(User $user, Operation $operation)
    {
        return Auth::id()->isAdmin();
    }

    /**
     * Determine whether the user can delete the operation.
     *
     * @param  \App\User  $user
     * @param  \App\Operation  $operation
     * @return mixed
     */
    public function delete(User $user, Operation $operation)
    {
        return Auth::id()->isAdmin();
    }

    /**
     * Determine whether the user can restore the operation.
     *
     * @param  \App\User  $user
     * @param  \App\Operation  $operation
     * @return mixed
     */
    public function restore(User $user, Operation $operation)
    {
        return Auth::id()->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the operation.
     *
     * @param  \App\User  $user
     * @param  \App\Operation  $operation
     * @return mixed
     */
    public function forceDelete(User $user, Operation $operation)
    {
        return Auth::id()->isAdmin();
    }
}
