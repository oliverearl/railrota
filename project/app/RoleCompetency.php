<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleCompetency extends Model
{
    protected $defaultGrades = [
        'Trainee',
        'Passed',
        'Examiner'
    ];

    protected $defaultPoweredDriverGrades = [
        'Trainee',
        'PW Passed',
        'PO Passed',
        'Examiner'
    ];

    protected $defaultSteamDriverGrades = [
        'Cleaner',
        'Passed Cleaner',
        'Fireman',
        'Passed Fireman',
        'Driver',
        'Examiner'
    ];

    public function getControllerDefaults() {
        return $this->defaultGrades;
    }

    public function getGuardDefaults() {
        return $this->defaultGrades;
    }

    public function getBlockmanDefaults() {
        return $this->defaultGrades;
    }

    public function getPoweredDefaults() {
        return $this->defaultPoweredDriverGrades;
    }

    public function getSteamDefaults() {
        return $this->defaultSteamDriverGrades;
    }
}
