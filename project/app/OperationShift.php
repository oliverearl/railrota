<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationShift extends Model
{
    protected $fillable = [
        'user_id',
        'role_type_id',
        'role_competency_id',
        'location_id',
        'steam_locomotive_id',
        'powered_locomotive_id',
        'notes',
    ];

    /**
     * TODO: This method is awful and needs to be recycled.
     * Why would anyone in their right mind need this much data?
     * Well, it's because of time constraints.
     */
    public static function getData()
    {
        return [
            'users' => User::all(['id', 'name', 'surname', 'is_available']),
            'role_types' => RoleType::all(['id', 'name']),
            // TODO: Refactor when competencies become a subset of role types
            //'role_competencies' => RoleCompetency::all(['id', 'name', 'role_type_id']),
            'locations' => Location::all(['id', 'name']),
            'steam_locomotives' => SteamLocomotive::all(['id', 'name']),
            'powered_locomotives' => PoweredLocomotive::all(['id', 'name']),
        ];
    }

    public function operation()
    {
        return $this->belongsTo('App\Operation', 'operation_id');
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
