<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Worker;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use DateTime;
use Illuminate\Support\Carbon;



class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $workers=Worker::all();
        return response()->json([
            "message"=>"successfull",
            "data"=> $workers
        ]);
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
    public function loginWorkers (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails())
        {
            $errors = $validator->errors();

            return response()->json([
                "message"=>"failed",
                "data"=>    $errors
            ]);
        }
        else
            {

            $phone=$request->input('phone');
            $password=$request->input('password');


            $worker=DB::table('workers')
                ->where('phone','=',$phone)
                ->where('password','=',$password)->first();
            if($worker)
            {
                if($worker->ban==1)
                {
                    $now=Carbon::now();
                    $difference=now()->diffInDays($worker->baned_at);
                    if($difference>=30)
                    { $updated=DB::table('workers')
                        ->where('phone','=',$phone)
                        ->where('password','=',$password)->update((['ban' => 0]));
                    if($updated)
                    {
                        $worker=DB::table('workers')
                            ->where('phone','=',$phone)
                            ->where('password','=',$password)->get();
                        return response()->json([
                            "message"=>"successfull",
                            "data"=>    $worker
                        ]);
                    }
                    else
                    {
                        return response()->json([
                            "message"=>"problem in update"
                        ]);
                    }
                    }
                    else{
                        return response()->json([
                            "message"=>"you are baned for 30 days",
                            "The remaining days   "=>30- $difference
                        ]);
                    }
                }
                else
                { return response()->json([
                    "message"=>"successfull",
                    "data"=>    $worker
                ]);
                }}
            else
            {
                return response()->json([
                    "message"=>"not found"
                ]);
            }
        }

    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:workers',
            'region' => 'required',
            'last_name'=>'required',
            'password' => 'required',
            'city' => 'required'
        ]);
        if ($validator->fails())
        {
            $errors = $validator->errors();

            return response()->json([
                "message"=>"failed",
                "data"=>    $errors
            ]);
        }
        $department=$request->input('dep_id');
        $worker=new Worker();
        $worker->name=$request->input('name');
        $worker->last_name=$request->input('last_name');
        $worker->password=$request->input('password');
        $worker->age=$request->input('age');
        $worker->email=$request->input('email');
        $worker->phone=$request->input('phone');
        $worker->region=$request->input('region');
        $worker->city=$request->input('city');
        $worker->status=$request->input('status');
        $worker->average_salary=$request->input('average_salary');
        $worker->total_rate=$request->input('total_rate');
        $worker->work=$request->input('work');
//        $worker->dept_id=$request->input('dept_id');

//        if($request->hasFile('image'))
//        {
//
//            $image = $request->image;  // your base64 encoded
//            $image = str_replace('data:image/png;base64,', '', $image);
//            $image = str_replace(' ', '+', $image);
//            $imageName = str_random(10).'.'.'png';
//            \File::put(public_path("/storage/workers"). '/' . $imageName, base64_decode($image));
//            $worker->image=$imageName;
//        }
//        else{

            $image = $request->image;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            \File::put(public_path("/storage/workers"). '/' . $imageName, base64_decode($image));
            $worker->image=$imageName;

            $image = $request->national_card;  // your base64 encoded
//            $the_image=$request->image;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            \File::put(public_path("/storage/nationalCards"). '/' . $imageName, base64_decode($image));
            $worker->national_card=$imageName;

        $image = $request->fish_tashbih;  // your base64 encoded
//            $the_image=$request->image;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10).'.'.'png';
        \File::put(public_path("/storage/criminalRecordEliminate"). '/' . $imageName, base64_decode($image));
        $worker->fish_tashbih=$imageName;



        /*
             $image = $request->national_card;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            \File::put(public_path("/storage/workers"). '/' . $imageName, base64_decode($image));
            $worker->image=$imageName;
//            $worker->photo=$the_image;
//        }
*/



        $worker->save();
        $id=$worker->id;
        DB::table('worker_department')->insert(array("dep_id"=>$department,"worker_id"=>$id));

        return response()->json([
            "message"=>"successfull",
            "data"=> $worker
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showWokerData(Request $request)
    {

        $id=$request->input('worker_id');
        $worker=Worker::find($id);
        $path='http://localhost:8000/storage/workers/'.$worker->image;
        $path2 ='http://localhost:8000/storage/nationalCards/'.$worker->national_card ;
        $path3 ='http://localhost:8000/storage/criminalRecordEliminate/'.$worker->fish_tashbih  ;
        $worker->image=$path;
        $worker->national_card=$path2;
        $worker->fish_tashbih=$path3;

        return response()->json([
            "message"=>"successfull",
            "data"=> $worker
        ]);
        //
    }
    public function storeBase69(Request $request)
    {
        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10).'.'.'png';
        \File::put(public_path("/storage/workers"). '/' . $imageName, base64_decode($image));
        return response()->json([
            "message"=>"successfull",
            "data"=> $imageName
        ]);

    }

    public function showWorkerPhoto(Request $request)
    {

        $id=$request->input('id');
        $worker=Worker::find($id);
        return response() ->download(public_path("/storage/workers/".$worker->image),'image');

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
    public function specifyStatus(Request $request)
    {
        $worker_id=$request->input('worker_id');
        $worker=Worker::find($worker_id);
        $worker->status=($request->input('status'));
        $worker->save();
        return response()->json([
            "message"=>"successfull",
            "workers"=> $worker
        ]);
    }


    public function showSpecificWorkers(Request $request)
    {
        $user_id=$request->input('user_id');
        $address=$request->input('city');
        $dept_id=$request->input('dept_id');
        $workers=DB::table('workers')
            ->join('worker_department','worker_department.worker_id','=','workers.id')
            ->join('departments','worker_department.dep_id','=','departments.id')
            ->where('address',$address)
            ->where('dep_id',$dept_id)
            ->where('status','=',"0")
            ->get();


        return response()->json([
            "message"=>"successfull",
            "workers"=> $workers
        ]);



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
        $worker=Worker::find($id);
        if($request->has('name'))
        {
            $newName=$request->name;
            $worker->name=$newName;
        };
        if($request->has('last_name'))
        {
            $last_name=$request->last_name;
            $worker->last_name=$last_name;
        }

        if($request->has('username'))
        {
            $username = '';
            $username=$request->username;
            $worker->username=$username;
        }
        if($request->has('password'))
        {

            $password = '';
            $password=$request->password;
            $worker->password=$password;
        }

        if($request->has('age'))
        {

            $age = '';
            $age=$request->age;
            $worker->age=$age;
        }
        if($request->has('email'))
        {

            $newEmail = '';
            $newEmail=$request->email;
            $worker->email=$newEmail;
        }

        if($request->has('work'))
        {

            $work = '';
            $work=$request->work;
            $worker->work=$work;
        }

        if($request->has('phone'))
        {
            $phone = '';
            $phone=$request->phone;
            $worker->phone=$phone;
        }

        if($request->has('address'))
        {
            $newAddress="";
            $newAddress=$request->address;
            $worker->address=$newAddress;
        }

        if($request->has('national_card'))
        {
            $national_card="";
            $national_card=$request->national_card;
            $worker->national_card=$national_card;
        }

        if($request->has('status'))
        {
            $status="";
            $status=$request->status;
            $worker->status=$status;
        }

        if($request->has('average_salary'))
        {
            $average_salary="";
            $average_salary=$request->average_salary;
            $worker->average_salary=$average_salary;
        }

        if($request->has('total_rate'))
        {
            $total_rate="";
            $total_rate=$request->total_rate;
            $worker->total_rate=$total_rate;
        }

        $worker->save();
        return response()->json([
            "message"=>"updated successfully",
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $worker=Worker::find($id);
        $worker->delete();
        return response()->json([
            "message"=>"deleted successfully",
        ]);


    }
}