<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'user_id',
        'role_type_id',
        'role_competency_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function role_type()
    {
        return $this->belongsTo('App\RoleType');
    }

    public function role_competency()
    {
        return $this->belongsTo('App\RoleCompetency', 'role_competency_id');
    }
}
