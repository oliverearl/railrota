<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminDashboardPolicy
{
    use HandlesAuthorization;

    public function view()
    {
        return Auth::id()->isAdmin();
    }
}
