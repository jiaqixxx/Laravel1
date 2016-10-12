<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    protected $guarded = [];
    public function bookings(){
        return $this->belongsToMany(Booking::class);
    }
}
