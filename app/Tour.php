<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    public function Tourdate(){
        return $this->hasMany('App\Tourdate');
    }
    
}
