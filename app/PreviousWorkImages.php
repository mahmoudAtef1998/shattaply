<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreviousWorkImages extends Model
{
    protected  $table='previous_work_images';
    //
    public  function bByUser(){
        return $this->belongsToMany("App\PreviousWork");
    }
}
