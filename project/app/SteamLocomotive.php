<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SteamLocomotive extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $defaultLocomotives = [
        'No. 7',
        'No 10',
    ];

    public function getDefaultLocomotives() {
        return $this->defaultLocomotives;
    }
}
