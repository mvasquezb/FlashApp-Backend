<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    public function scheduledService()
    {
        return $this->belongsTo('App\ScheduledService');
    }
}
