<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduledService extends Model
{
    public function seller()
    {
        return $this->hasOne('App\User');
    }

    public function serviceType()
    {
        return $this->hasOne('App\ServiceType');
    }

    public function schedule()
    {
        // TODO: Check if it has only one schedule or multiple
        return $this->hasOne('App\Schedule');
    }

    public function serviceInstances()
    {
        return $this->hasMany('App\Service');
    }
}
