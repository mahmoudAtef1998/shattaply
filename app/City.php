<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function regions(){
        $this->hasMany('App\Region');
    }
}
