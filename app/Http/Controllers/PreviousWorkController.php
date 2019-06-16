<?php

namespace App\Http\Controllers;

use App\PreviousWork;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use function Sodium\add;
use App\PreviousWorkImages;


class PreviousWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $worker_id=$request->input('worker_id');
        $title=$request->input('title');
        $description=$request->input('description');



        $previousWork=new PreviousWork();
        $previousWork->worker_id= $worker_id;
        $previousWork->description=$description;
        $previousWork->title=$title;
        $previousWork->save();
        $id= DB::table('previous_works')->orderBy('id','desc')->first()->id;
            $image = $request->image;  // your base64 encoded
            $previousWorkImage=new PreviousWorkImages();
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            \File::put(public_path("//storage/previousWorks"). '/' . $imageName, base64_decode($image));
            $previousWorkImage->image=$imageName;
            $previousWorkImage->previousWork_id=$id;
            $previousWorkImage->save();








//        $i=0;
//        while ($i<5)
//        {
//            if($request->hasFile('image'.$i))
//            {
//
//                $file=$request->file('image'.$i);
//                $previousWorkImage=new PreviousWorkImages();
//                $extension=$file->getClientOriginalExtension();
//                $filename=$i.time().'.'.$extension;
//                $file->move(public_path("/storage/previousWorks/".$id),$filename);
//                $previousWorkImage->image=$filename;
//                $previousWorkImage->previousWork_id=$id;
//                $previousWorkImage->save();
//
//                $i+=1;
//            }
//            else{
//                break;
//            }
//        }

        return response()->json([
            "message"=>"successfull",
            "data"=>$previousWork
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $id=$request->input('worker_id');
        $previousWOrks = DB::table('previous_works')
            ->where('worker_id','=',$id )
            ->join('previous_work_images','previous_works.id' , '=', 'previous_work_images.previousWork_id')
            ->select('previous_work_images.previousWork_id','previous_work_images.image','previous_works.description','previous_works.title')
            ->get();
        $collection=collect();

        foreach($previousWOrks as $previousWork):
            {
//            $previousWork_id=$previousWork->previousWork_id;
                 $collection1=collect();
                $previousWork_image=$previousWork->image;
                $link='http://localhost:8000/storage/previousWorks'.'/'.$previousWork_image;

                $collection1->push($previousWork->title);
                $collection1->push($previousWork->description);
                $collection1->push($link);
                $collection->push($collection1);
            }
            endforeach;



        return response()->json([
            "message"=>"a7a",
            "data"=>$collection
        ]);

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
