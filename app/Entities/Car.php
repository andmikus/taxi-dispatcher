<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model', 'year', 'number'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Entities\Profile');
    }

}
