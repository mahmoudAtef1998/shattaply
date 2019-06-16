<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use function Sodium\add;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users=User::all();
        return response()->json([
            "message"=>"successfull",
            "data"=> $users
        ]);
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
    public function loginUsers(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
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
        else{

            $email=$request->input('email');
            $password=$request->input('password');


            $user=DB::table('users')
                ->where('email','=',$email)
                ->where('password','=',$password)->first();
            if($user)
                {
                     if($user->ban==1)
                {
                    $now=Carbon::now();
                    $difference=now()->diffInDays($user->baned_at);
                    if($difference>=30)
                    { $updated=DB::table('users')
                        ->where('email','=',$email)
                        ->where('password','=',$password)->update((['ban' => 0]));
                    if($updated)
                    {
                        $user=DB::table('users')
                        ->where('email','=',$email)
                        ->where('password','=',$password)->get();
                        return response()->json([
                            "message"=>"successfull",
                            "data"=>    $user
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
                    "data"=>    $user
                ]);
                }

                }
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
            'email' => 'required|unique:users',
            'name' => 'required',
            'last_name'=>'required',
            'password' => 'required',
            'address' => 'required'
        ]);
        if ($validator->fails())
        {
            $errors = $validator->errors();

            return response()->json([
                "message"=>"failed",
                "data"=>    $errors
            ]);
        }
        else{

        $user=$request->all();
        $user=new User();
        $user->name=$request->input('name');
        $user->last_name=$request->input('last_name');
        $user->address =$request->input('address');
        $user->email=$request->input('email');
        $email=$request->input('email');
        $user->phone_number=$request->input('phone_number');
        $user->age=$request->input('age');
        $user->password=$request->input('password');


        if($request->hasFile('image'))
        {
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move(public_path("/storage/users"),$filename);
            $user->image=$filename;
        }

        else{
            $user->image='';
        }

        $user->save();
        return response()->json([
            "message"=>"successfull",
            "data"=> $user
        ]);
    }}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUserPhoto(Request $request)
    {
        $id=$request->input('user_id');
        $user=User::find($id);
        return response() ->download(public_path("/storage/users/".$user->image),'image');
    }
    public function showUserData(Request $request)
    {
        $id=$request->input('user_id');
        $user=User::find($id);
        $path='http://localhost:8000/storage/users/'.$user->image;
        $user->image=$path;
        return response()->json([
            "message"=>"successfull",
            "data"=> $user
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
    public function update(Request $request)
    {
        $id=$request->input('id');
        $user=User::find($id);
        if($request->has('name'))
        {
            $newName="";
            $newName=$request->name;
            $user->name=$newName;
        }

        if($request->hasFile('image')) {
//            $temp=1;
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            if($filename==$user->image)
            {
                $filename='m7mod'.$filename;
            }
            $file->move(public_path("/storage/users"), $filename);

            $user->image = $filename;
        }

        if($request->has('username'))
        {
            $username = '';
            $username=$request->username;
            $user->username=$username;
        }

        if($request->has('address'))
        {
            $newAddress="";
            $newAddress=$request->address;
            $user->address=$newAddress;
        }

        if($request->has('email'))
        {
            $newEmail = '';
            $newEmail=$request->email;
            $user->email=$newEmail;
        }

        if($request->has('phone_number'))
        {
            $phone_number = '';
            $phone_number=$request->phone_number;
            $user->phone_number=$phone_number;
        }


        if($request->has('age'))
        {
            $age ='';
            $age=$request->age;
            $user->age=$age;
        }

        if($request->has('password'))
        {
            $password = '';
            $password=$request->password;
            $user->password=$password;
        }









        $user->save();
        return response()->json([
            "message"=>"updated successfully",
            "data"=> $user
        ]);
    }
//    public function updatePhoto(Request $request, $id)
//    {
//        $user=User::find($id);
//
//
//
//        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        $user->delete();
        return response()->json([
            "message"=>"deleted successfully",
        ]);
    }

    public function search(Request $request){
        $region= $request ->input('region');
        $city = $request->input('city');
        $value=$request->input('value');

        if($value == 1){
            $worker=DB::table('workers')->where('region','=',$region)
               ->where('city','=',$city)
                ->where('status','=',"0")
                ->orderBy('total_rate','desc')->get();
            $others=DB::table('workers')
                ->where('city','=',$city)
                ->where('region','!=',$region)
                ->orderBy('total_rate','desc')->get();






            if($worker){
                return response()->json([
                    "message"=>"her is the workers",
                    "data"=>$worker,
                    "others"=>$others
                ]);

            }else{
                $worker =DB::table('workers')->where('city','=',$city)->orderBy('total_rate','desc')->get();
                return response()->json([
                    "message"=>"her is the workers",
                    "data"=>$worker
                ]);

            }





        }elseif ($value == 2){
            $worker=DB::table('workers')->where('total_rate','>=',3)->orderBy('total_rate','desc')->get();
            return response()->json([
                "message"=>"her is the workers",
                "data"=>$worker
            ]);
        }


    }


}