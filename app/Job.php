<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function Evaluation(){
        return $this->hasOne("App\Evaluation");

    }
    public function complain(){
        return $this->hasOne("App\Complain");

    }
    public function request(){
        return $this->hasOne("App\Request");
    }
}
