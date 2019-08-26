<?php

namespace App\Policies;

use App\User;
use App\PoweredLocomotive;
use Illuminate\Auth\Access\HandlesAuthorization;

class PoweredLocomotivePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any powered locomotives.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the powered locomotive.
     *
     * @param  \App\User  $user
     * @param  \App\PoweredLocomotive  $poweredLocomotive
     * @return mixed
     */
    public function view(User $user, PoweredLocomotive $poweredLocomotive)
    {
        //
    }

    public function manipulate()
    {
        return Auth::id()->isAdmin();
    }

    /**
     * Determine whether the user can restore the powered locomotive.
     *
     * @param  \App\User  $user
     * @param  \App\PoweredLocomotive  $poweredLocomotive
     * @return mixed
     */
    public function restore(User $user, PoweredLocomotive $poweredLocomotive)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the powered locomotive.
     *
     * @param  \App\User  $user
     * @param  \App\PoweredLocomotive  $poweredLocomotive
     * @return mixed
     */
    public function forceDelete(User $user, PoweredLocomotive $poweredLocomotive)
    {
        //
    }
}
