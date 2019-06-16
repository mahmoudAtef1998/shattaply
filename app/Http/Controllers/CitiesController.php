<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Sodium\add;
use Illuminate\Support\Arr;

class CitiesController extends Controller
{
    public function getCities(){
        $cities =DB::table('cities')->select('city','id')->get();
        $collections=collect();
        foreach ($cities as $city){
            $id=$city->id;
            $region =DB::table('regions')->where('city_id','=',$id)->select('reg')->get();
            $collection=collect();
            $collection->push($city);
            $collection->push($region);
            $collections->push($collection);

        }
         return response()->json([
             'data'=>$collections
         ]);



    }
}
