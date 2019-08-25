<?php

namespace App\Policies;

use App\RoleCompetency;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class RoleCompetencyPolicy
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
     * @param \App\User $user
     * @param RoleCompetency $roleCompetency
     * @return mixed
     */
    public function view(User $user, RoleCompetency $roleCompetency)
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
     * @param \App\User $user
     * @param RoleCompetency $roleCompetency
     * @return mixed
     */
    public function restore(User $user, RoleCompetency $roleCompetency)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the role type.
     *
     * @param \App\User $user
     * @param RoleCompetency $roleCompetency
     * @return mixed
     */
    public function forceDelete(User $user, RoleCompetency $roleCompetency)
    {
        //
    }
}

