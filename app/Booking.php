<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function passengers(){
        return $this->belongsToMany(Passenger::class);
    }
}
