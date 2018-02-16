<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

    public function profile()
    {
        return $this->hasOne('App\Entities\Profile');
    }

    public function shifts()
    {
        return $this->hasMany('App\Entities\Shift', 'driver_id');
    }

    public function isAdmin()
    {
        return $this->profile->type === 'admin';
    }

    public function isDriver()
    {
        return $this->profile->type === 'driver';
    }

    public function isDispatcher()
    {
        return $this->profile->type === 'dispatcher';
    }

    public function scopeDriver($query)
    {
        return $query->whereHas('profile' , function ($query) {
            $query->where('type', 'driver');
        });
    }

    public function inShift()
    {
        $lastShift = $this->shifts()->latest()->first();

        if ( ! empty($lastShift)) {
            return ($lastShift->end_date == NULL);
        }

        return FALSE;
    }
}
