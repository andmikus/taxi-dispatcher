<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_location', 'end_location', 'start_address', 'end_address',
        'start_time', 'passenger_phone', 'status'
    ];

    public function driver()
    {
        return $this->belongsTo('App\Entities\User', 'driver_id');
    }

}
