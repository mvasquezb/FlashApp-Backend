<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function status()
    {
        return $this->hasOne('App\ServiceStatus');
    }

    public function scheduledService()
    {
        return $this->belongsTo('App\ScheduledService');
    }

    public function customers()
    {
        return $this->hasManyThrough('App\Person', 'App\ServiceCustomers');
    }

    public function serviceCustomers()
    {
        return $this->hasMany('App\ServiceCustomers');
    }
}
