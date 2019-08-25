<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleType extends Model
{

    protected $oldDefaultTypes = [
        'Trainee',
        'Guard',
        'Instructor',
        'Driver',
        'Blockman',
        'Fireman',
        'Cleaner',
        'Passed Fireman',
        'Passed Cleaner',
    ];

    protected $defaultTypes = [
        'Controller',
        'Guard',
        'Blockman',
        'Driver - Diesel and Electric',
        'Driver - Steam Locomotive'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    public function role() {
        return $this->hasOne('App\Role');
    }

    public function role_competencies() {
        return $this->hasMany('App\RoleCompetency');
    }

    public function getDefaultTypes() {
        return $this->defaultTypes;
    }

    public function getAllRoleTypes() {
        return RoleType::all();
    }
}
