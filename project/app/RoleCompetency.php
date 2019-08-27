<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleCompetency extends Model
{

    protected $fillable = [
        'role_type_id',
        'name',
        'description',
        'tier',
    ];

    protected $defaultGrades = [
        'Trainee' => 1,
        'Passed' => 2,
        'Examiner' => 3,
    ];

    protected $defaultPoweredDriverGrades = [
        'Trainee' => 1,
        'PW Passed' => 2,
        'PO Passed' => 3,
        'Examiner' => 4,
    ];

    protected $defaultSteamDriverGrades = [
        'Cleaner' => 1,
        'Passed Cleaner' => 2,
        'Fireman' => 3,
        'Passed Fireman' => 4,
        'Driver' => 5,
        'Examiner' => 6,
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function role_type()
    {
        return $this->belongsTo('App\RoleType');
    }

    public function operation_shifts()
    {
        return $this->hasMany('App\OperationShift');
    }

    public function getControllerDefaults()
    {
        return $this->defaultGrades;
    }

    public function getGuardDefaults()
    {
        return $this->defaultGrades;
    }

    public function getBlockmanDefaults()
    {
        return $this->defaultGrades;
    }

    public function getPoweredDefaults()
    {
        return $this->defaultPoweredDriverGrades;
    }

    public function getSteamDefaults()
    {
        return $this->defaultSteamDriverGrades;
    }
}
