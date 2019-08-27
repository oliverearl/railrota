<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoweredLocomotive extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $defaultLocomotives = [
        'No. 5',
        'No. 6',
        'No. 9',
        'No. 11',
    ];

    public function getDefaultLocomotives()
    {
        return $this->defaultLocomotives;
    }

    public function operation_shifts()
    {
        return $this->hasMany('App\OperationShift');
    }
}
