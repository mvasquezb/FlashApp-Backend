<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public function pets()
    {
        return $this->hasMany('App\Pet');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
