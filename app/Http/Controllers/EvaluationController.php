<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluation;
use Illuminate\Support\Facades\DB;
use App\Worker;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluations=Evaluation::all();
        return response()->json([
            "message"=>"successfull",
            "data"=> $evaluations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $validatedData = $request->validate([
//            'rate' => 'required',
//            'service_time' => 'required',
//            'service_description' => 'required',
//            'worker_moral' => 'required',
//        ]);
        $worker_id=$request->input('worker_id');
        $user_id=$request->input('user_id');
        $job=DB::table('jobs')
            ->join('jop_requests','jop_requests.id','=','jobs.request_id')
            ->where('worker_id',$worker_id)
            ->where('user_id',$user_id)
            ->count();
        if($job>0)
        {

            $evaluation=new Evaluation();
            $evaluation->rate=$request->input('rate');
            $evaluation->service_time=$request->input('service_time');
            $evaluation->service_description=$request->input('service_description');
            $evaluation->worker_moral=$request->input('worker_moral');
            $evaluation->worker_id=$worker_id;
            $evaluation->user_id=$user_id;

            $evaluation->save();
            $total_rate=DB::table('evaluations')
                ->where('worker_id','=',$worker_id)
                ->select('rate')->avg('rate');
            $worker=WOrker::find($worker_id);
            $worker->total_rate=$total_rate;
            $worker->save();
            $evaluation->save();
            return response()->json([
                "message"=>"successfull",
                "data"=> $total_rate
            ]);
        }
        else {
            return response()->json([
                "message"=>"no previous deal",
            ]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id=$request->input('id');
        $evaluation=Evaluation::find($id);
        return response()->json([
            "message"=>"successfull",
            "data"=> $evaluation
        ]);   //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $evaluation=Evaluation::find($id);
        $newRate=$request->rate;
        $evaluation->rate=$newRate;
        $evaluation->save();
        return response()->json([
            "message"=>"updated successfully",
        ]);
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
        $evaluation=Evaluation::find($id);
        $evaluation->delete();
        return response()->json([
            "message"=>"deleted successfully",
        ]);
        //
    }
}