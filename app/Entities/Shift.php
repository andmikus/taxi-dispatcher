<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_date', 'end_date'
    ];

    protected $dates = [
        'start_date', 'end_date'
    ];

    public function driver()
    {
        return $this->belongsTo('App\Entities\User','driver_id');
    }

}
