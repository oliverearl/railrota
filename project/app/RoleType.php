<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleType extends Model
{

    protected $defaultTypes = [
        'trainee',
        'guard',
        'instructor',
        'driver',
        'blockman',
        'fireman',
        'cleaner',
        'passed_fireman',
        'passed_cleaner',
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


    public function getDefaultTypes(): Array {
        return $this->defaultTypes;
    }

    public function role() {
        return $this->belongsTo('App\Role');
    }
}
