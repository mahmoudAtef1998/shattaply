<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\JopRequest;

class JopRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id=$request->input('id');
        $requests = DB::table('jop_requests')
            ->where('worker_id',$id)->where('state','=',"avaliable")
            ->join('users','users.id' , '=', 'jop_requests.user_id')
            ->get();
        return response()->json([
            "message"=>"successfull",
            "data"=> $requests
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
            'description' => 'required',
            'location' => 'required',
            'state' => 'required',
            'worker_id' => 'required',
            'user_id' => 'required',
        ]);

        $the_request=new JopRequest();
        $the_request->description=$request->input('description');
        $the_request->location=$request->input('location');
        $the_request->state=('state');
        $the_request->worker_id=$request->input('worker_id');
        $the_request->user_id=$request->input('user_id');
        $the_request->state="avaliable";
        $the_request->save();
        return response()->json([
            "message"=>"successfull",
            "data"=> $the_request
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
        $id1=$request->input('id1');
        $id2=$request->input('id2');
        $joprequest = DB::table('jop_requests')
            ->where('worker_id','=',$id1 )->where('id','=',$id2)->get();
        return response()->json([
            "message"=>"successfull",
            "data"=> $joprequest
        ]);
    }

    public function showWorkerRequests(Request $request)
    {
        $id1=$request->input('worker_id');
        $joprequest = DB::table('jop_requests')
            ->join('users','jop_requests.user_id','=','users.id')
            ->where('worker_id','=',$id1 )
            ->where('state','=','avaliable')
            ->get();
        return response()->json([
            "message"=>"successfull",
            "data"=> $joprequest
        ]);
    }

    public function showUserRequests(Request $request)
    {
        $id1=$request->input('user_id');
        $joprequest = DB::table('jop_requests')
            ->join('workers','jop_requests.worker_id','=','workers.id')
            ->where('user_id','=',$id1 )->get();
        return response()->json([
            "message"=>"successfull",
            "data"=> $joprequest
        ]);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Workerdestroy($id1,$id2)
    {
        $joprequest = DB::table('jop_requests')
            ->where('worker_id','=',$id1 )->where('id','=',$id2)->update(['state'=>"deletedByWorker"]);
        return response()->json([
            "message"=>"deleted successfully",
        ]);
    }

    public function workerAccept($id1,$id2)
    {
        $joprequest = DB::table('jop_requests')
            ->where('worker_id','=',$id1 )
            ->where('user_id','=',$id2)
            ->update(['state'=>"accepted"]);

        $request_id = DB::table('jop_requests')
            ->where('worker_id','=',$id1 )
            ->where('user_id','=',$id2)
            ->select('id')
            ->first();
//            ->get();
        $theReuestId=$request_id->id;
        DB::table('jobs')->insert(array('request_id'=>$theReuestId));
//        DB::table('jobs')->insert(array("request_id"=>$the_jop_request->id));

        return response()->json([
            "message"=>"accepted successfully",
            "data"=> is_integer($theReuestId)
        ]);
    }


    public function userdestroy($id1,$id2)
    {
        $joprequest = DB::table('jop_requests')
            ->where('user_id','=',$id1 )->where('id','=',$id2)->update(['state'=>"deletedByUser"]);
        return response()->json([
            "message"=>"deleted successfully",
        ]);
    }
}