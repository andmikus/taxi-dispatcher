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
        'origin_location', 'destination_location', 'origin_address', 'destination_address',
        'start_time', 'passenger_phone', 'status', 'driver_id'
    ];

    public function driver()
    {
        return $this->belongsTo('App\Entities\User', 'driver_id');
    }

}
