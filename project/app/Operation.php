<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'date',
        'is_running',
        'notes'
    ];

    public function operation_shifts()
    {
        return $this->hasMany('App\OperationShift');
    }
}
