<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slot extends Model
{
    use SoftDeletes;

    protected $fillable = [ "start", "end", "site_id", "car_id", "available_amount"];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function commercial()
    {
        return $this->belongsTo('App\Commercial');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function getAvailableAttribute()
    {
    return $this->available_amount > $this->bookings()->count();
    }
}
