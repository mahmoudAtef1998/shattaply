<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function browse(){
       return $this->belongsToMany("App\Department");
    }

    public function Crequests(){
        return $this->hasMany("App\JopRequest");
    }

    public function Cevaluations(){
        return $this->hasMany("App\Evaluation");
    }
}

