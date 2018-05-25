<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduledService extends Model
{
    public function seller()
    {
        return $this->hasOne('App\Person');
    }

    public function serviceType()
    {
        return $this->hasOne('App\ServiceType');
    }
}
