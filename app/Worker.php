<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public function department(){
        return $this->belongsToMany("App\Department");
    }

    public function works(){
        return $this->hasMany("App\PreviousWork");
    }
    public function Wrequests(){
        return $this->hasMany("App\JopRequest");
    }

    public function Wevaluations(){
        return $this->hasMany("App\Evaluation");
    }

}
