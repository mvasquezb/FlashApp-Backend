<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    public function owner()
    {
        return $this->belongsToOne('App\Person');
    }

    public function animalType()
    {
        return $this->hasOne('App\AnimalType');
    }
}
