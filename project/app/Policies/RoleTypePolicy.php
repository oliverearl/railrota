<?php

namespace App\Policies;

use App\User;
use App\RoleType;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoleTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any role types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the role type.
     *
     * @param  \App\User  $user
     * @param  \App\RoleType  $roleType
     * @return mixed
     */
    public function view(User $user, RoleType $roleType)
    {
        //
    }

    public function manipulate()
    {
        return Auth::id()->isAdmin();
    }

    /**
     * Determine whether the user can restore the role type.
     *
     * @param  \App\User  $user
     * @param  \App\RoleType  $roleType
     * @return mixed
     */
    public function restore(User $user, RoleType $roleType)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the role type.
     *
     * @param  \App\User  $user
     * @param  \App\RoleType  $roleType
     * @return mixed
     */
    public function forceDelete(User $user, RoleType $roleType)
    {
        //
    }
}
