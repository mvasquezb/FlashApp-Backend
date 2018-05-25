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

    public function scheduledServices()
    {
        return $this->hasMany('App\ScheduledServices');
    }

    public function services()
    {
        return $this->hasManyThrough('App\Service', 'App\ServiceCustomer');
    }

    // TODO: Add seller and customer ratings getters
}
