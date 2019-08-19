<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * Remembrance token, email verification indicator,
     * timestamps, and admin flag are guarded.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone_home',
        'phone_work',
        'phone_mobile',
        'date_of_last_inspection',
        'notes',
        'is_available',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * This is mainly being used to convert dates data into actual dates.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_last_inspection' => 'date',
    ];

    public function roles() {
        return $this->hasMany('App\Role');
    }
}
