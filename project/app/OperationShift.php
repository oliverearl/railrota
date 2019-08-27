<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationShift extends Model
{
    protected $fillable = [
        'operation_id',
        'user_id',
        'role_type_id',
        'role_competency_id',
        'location_id',
        'steam_locomotive_id',
        'powered_locomotive_id',
        'notes',
    ];

    public function operation()
    {
        return $this->belongsTo('App\Operation');
    }

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
        return $this->belongsTo('App\RoleCompetency');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function steam_locomotive()
    {
        return $this->belongsTo('App\SteamLocomotive');
    }

    public function powered_locomotive()
    {
        return $this->belongsTo('App\PoweredLocomotive');
    }
}
