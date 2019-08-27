<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    protected $defaultLocations = [
        'Maespoeth',
        'Corris'
    ];

    public function getDefaultLocations()
    {
        return $this->defaultLocations;
    }

    public function operation_shifts()
    {
        return $this->hasMany('App\OperationShift');
    }
}
