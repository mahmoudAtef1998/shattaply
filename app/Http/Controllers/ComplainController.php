<?php

namespace App\Http\Controllers;

use App\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Carbon;
class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
    public function storeUserComplain(Request $request)
    {
        $complain=new Complain();
        $complain->comp_description=$request->input('comp_description');
        $complain->job_id=$request->input('job_id');
        $job_id=$request->input('job_id');
        $complain->complainant='user';
        $exists=DB::table('complains')
            ->where('complainant','=','user')
            ->where('job_id','=',$job_id)
            ->count();
        if($exists>=1)
        {
            return response()->json([
                "message"=>"complaint already exists"
            ]);
        }

        else
            {
        $complain->save();

        $worker_id=DB::table('jobs')
            ->join('jop_requests','jobs.request_id','=','jop_requests.id')
            ->where('jobs.id','=',$job_id)
            ->select('worker_id')->first();

        $theWorkertId=$worker_id->worker_id;

        $complain_count=$details=DB::table('complains')
            ->join('jobs','complains.job_id','=','jobs.id')
            ->join('jop_requests','jobs.request_id','=','jop_requests.id')
            ->where('worker_id','=',$theWorkertId)
            ->where('complainant','=','user')
            ->where('counted','=','1')->count();
        if($complain_count>=4)
        {
            $now=Carbon::now();

            $exists=DB::table('workers')
                ->where('id','=',$theWorkertId)
                ->update((['ban' => 1,'baned_at'=>$now]));
            $Zero_counted=DB::table('complains')
                ->join('jobs','complains.job_id','=','jobs.id')
                ->join('jop_requests','jobs.request_id','=','jop_requests.id')
                ->where('worker_id','=',$theWorkertId)
                ->where('complainant','=','user')
                ->update((['counted' => 0]));

        }
        else
            {

        }



        return response()->json([
            "message"=>"successfull",
            "data"=> $complain_count
        ]);


    }
}


    public function storeWorkerComplain(Request $request)
    {

        $complain=new Complain();
        $complain->comp_description=$request->input('comp_description');
        $complain->job_id=$request->input('job_id');
        $job_id=$request->input('job_id');
        $complain->complainant='worker';
        $exists=DB::table('complains')
            ->where('complainant','=','worker')
            ->where('job_id','=',$job_id)
            ->count();
       if($exists>=1)
        {
            return response()->json([
                "message"=>"complaint already exists"
            ]);
        }
        else
        {

        $complain->save();

            $user_id=DB::table('jobs')
                ->join('jop_requests','jobs.request_id','=','jop_requests.id')
                ->where('jobs.id','=',$job_id)
                ->select('user_id')->first();

            $theUserId=$user_id->user_id;
            $complain_count=$details=DB::table('complains')
                ->join('jobs','complains.job_id','=','jobs.id')
                ->join('jop_requests','jobs.request_id','=','jop_requests.id')
                ->where('user_id','=',$theUserId)
                ->where('complainant','=','worker')
                ->where('counted','=','1')->count();


            if($complain_count>=4)
            {
                   $now=Carbon::now();
                   $exists=DB::table('users')
                    ->where('id','=',$theUserId)
                    ->update((['ban' => 1,'baned_at'=>$now]));
                $Zero_counted=DB::table('complains')
                    ->join('jobs','complains.job_id','=','jobs.id')
                    ->join('jop_requests','jobs.request_id','=','jop_requests.id')
                    ->where('user_id','=',$theUserId)
                    ->where('complainant','=','worker')
                    ->update((['counted' => 0]));

            }
            else
            {

            }


            return response()->json([
            "message"=>"successfull",
                "data"=> $complain
        ]);
   }}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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