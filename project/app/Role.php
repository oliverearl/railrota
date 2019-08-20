<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'user_id',
        'role_type_id',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function role_type() {
        return $this->belongsTo('App\RoleType');
    }
}
