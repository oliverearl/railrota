<?php

namespace App\Policies;

use App\User;
use App\OperationShift;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class OperationShiftPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any operation shifts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the operation shift.
     *
     * @param  \App\User  $user
     * @param  \App\OperationShift  $operationShift
     * @return mixed
     */
    public function view(User $user, OperationShift $operationShift)
    {
        //
    }

    /**
     * Determine whether the user can create operation shifts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::id()->isAdmin();
    }

    /**
     * Determine whether the user can update the operation shift.
     *
     * @param  \App\User  $user
     * @param  \App\OperationShift  $operationShift
     * @return mixed
     */
    public function update(User $user, OperationShift $operationShift)
    {
        return Auth::id()->isAdmin();
    }

    /**
     * Determine whether the user can delete the operation shift.
     *
     * @param  \App\User  $user
     * @param  \App\OperationShift  $operationShift
     * @return mixed
     */
    public function delete(User $user, OperationShift $operationShift)
    {
        return Auth::id()->isAdmin();
    }

    public function register(User $user, OperationShift $operationShift)
    {
        //
    }

    public function deregister(User $user, OperationShift $operationShift)
    {
        //
    }

    /**
     * Determine whether the user can restore the operation shift.
     *
     * @param  \App\User  $user
     * @param  \App\OperationShift  $operationShift
     * @return mixed
     */
    public function restore(User $user, OperationShift $operationShift)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the operation shift.
     *
     * @param  \App\User  $user
     * @param  \App\OperationShift  $operationShift
     * @return mixed
     */
    public function forceDelete(User $user, OperationShift $operationShift)
    {
        //
    }
}
