<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    public function pets()
    {
        return $this->hasMany('App\Pet');
    }

    public function scheduledServices()
    {
        return $this->hasMany('App\ScheduledServices');
    }

    public function services()
    {
        return $this->hasManyThrough('App\Service', 'App\ServiceCustomer');
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
