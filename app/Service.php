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
}
