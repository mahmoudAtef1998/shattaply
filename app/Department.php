<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public  function bByUser(){
        return $this->belongsToMany("App\User");

    }
    public function workers(){
        return $this->belongsToMany("App\Worker");
    }

}
