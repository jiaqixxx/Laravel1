<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tourdate extends Model
{
    public function Tour (){
        return $this->belongsTo('App\Tour');
    }
}
