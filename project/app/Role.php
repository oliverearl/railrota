<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function role_type() {
        return $this->belongsTo('App\RoleType');
    }
}
