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
        $error = '';

        // Admins can override regardless
        if (Auth::id()->isAdmin()) {
            return true;
        }

        // Do they have the required role type?
        if ($user->role_type_id === $operationShift->role_type_id) {

            // Then check for privilege levels based on tier, or if one isn't specified
            if (is_null($operationShift->tier || $user->role_type->tier >= $operationShift->role_type->tier)) {
                return true;
            } else {
                $error = 'You do not have the required competency / grade level.';
            }
        } else {
            $error = 'You do not have the role type.';
        }

        // The shift must not already have a user assigned to it
        if (!is_null($operationShift->user_id) && $operationShift->user_id !== $user->id) {
            $error = 'This shift is not vacant.';
        }

        flash()->error($error)->important();
        return redirect()->back();
    }

    public function deregister(User $user, OperationShift $operationShift)
    {
        if (Auth::id()->isAdmin()) {
            return true;
        }

        if ($user->id === $operationShift->user_id) {
            return true;
        }

        return false;
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
