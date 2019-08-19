<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleType extends Model
{

    protected $defaultTypes = [
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
        return $this->hasOne('App\Role');
    }
}
