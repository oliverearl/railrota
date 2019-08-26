<?php

namespace App\Policies;

use App\User;
use App\SteamLocomotive;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class SteamLocomotivePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any steam locomotives.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the steam locomotive.
     *
     * @param  \App\User  $user
     * @param  \App\SteamLocomotive  $steamLocomotive
     * @return mixed
     */
    public function view(User $user, SteamLocomotive $steamLocomotive)
    {
        //
    }

    public function manipulate()
    {
        return Auth::id()->isAdmin();
    }

    /**
     * Determine whether the user can restore the steam locomotive.
     *
     * @param  \App\User  $user
     * @param  \App\SteamLocomotive  $steamLocomotive
     * @return mixed
     */
    public function restore(User $user, SteamLocomotive $steamLocomotive)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the steam locomotive.
     *
     * @param  \App\User  $user
     * @param  \App\SteamLocomotive  $steamLocomotive
     * @return mixed
     */
    public function forceDelete(User $user, SteamLocomotive $steamLocomotive)
    {
        //
    }
}
