<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
//    public function Ejob(){
//        return $this->belongsTo("App\Job");
//    }
    public function client(){
        return $this->belongsTo("App\User");

    }
    public function worker(){
        return $this->belongsTo("App\Worker");
    }
}
