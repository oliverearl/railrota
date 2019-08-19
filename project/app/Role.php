<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function user() {
        $this->belongsTo('App\User', 'user_id');
    }

    public function role_type() {
        $this->hasOne('App\RoleType', 'role_type_id');
    }
}
