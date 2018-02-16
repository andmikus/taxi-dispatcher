<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
    ];

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function car()
    {
        return $this->hasOne('App\Entities\Car');
    }
}
