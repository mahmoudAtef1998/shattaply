<?php

namespace App\Http\Controllers;

use App\City;
use App\Complain;
use App\Evaluation;
use App\Region;
use App\User;
use App\Worker;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins=Admin::all();
        return response()->json([
            "message"=>"successfull",
            "data"=> $admins
            ]);
        //
    }
    public  function all(){
        $workers= Worker::all();
        return view('admin.workers.index')->with('workers',$workers);
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
        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
            'last_name' => 'required',
            'email' => 'required',
            'name' => 'required',
            'password' => 'required',
            'username' => 'required',
        ]);

        $admin=new Admin();
        $admin->address=$request->input('address');
        $admin->phone_number=$request->input('phone_number');
        $admin->last_name=$request->input('last_name');
        $admin->email=$request->input('email');
        $admin->name=$request->input('name');
        $admin->password=$request->input('password');
        $admin->username=$request->input('username');

        if($request->hasFile('image'))
        {
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move(public_path("/storage/admins"),$filename);
//            Storage::put( $filename,$file);
//
            $admin->image=$filename;
        }
        else{

            $admin->image='';
        }



        $admin->save();
        return response()->json([
            "message"=>"successfull",
            "data"=> $admin
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUserData(Request $request)
    {
        $id=$request->input('id');
        $admin=Admin::find($id);
        $path='http://localhost:8000/storage/users/'.$admin->image;
        $admin->image=$path;
        return response()->json([
            "message"=>"successfull",
            "data"=> $admin
        ]);
    }
    public function showUserPhoto(Request $request)
    {
        $id=$request->input('id');
        $admin=Admin::find($id);
        return response() ->download(public_path("/storage/admins/".$admin->image),'image');
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin=Admin::find($id);
        if($request->has('name'))
        {
            $newName=$request->name;
            $admin->name=$newName;
        }
        if($request->hasFile('image')) {
//            $temp=1;
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            if($filename==$admin->image)
            {
                $filename='m7mod'.$filename;
            }
            $file->move(public_path("/storage/admins"), $filename);

            $admin->image = $filename;
        }


        if($request->has('username'))
        {
            $username = '';
            $username=$request->username;
            $admin->username=$username;
        }
        if($request->has('password'))
        {

            $password = '';
            $password=$request->password;
            $admin->password=$password;
        }
        if($request->has('email'))
        {

            $newEmail = '';
            $newEmail=$request->email;
            $admin->email=$newEmail;
        }


        if($request->has('last_name'))
        {
            $last_name=$request->last_name;
            $admin->last_name=$last_name;
        }
        if($request->has('phone_number'))
        {

            $phone_number = '';
            $phone_number=$request->phone_number;
            $admin->phone_number=$phone_number;
        }
        if($request->has('address'))
        {
            $newAddress="";
            $newAddress=$request->address;
            $admin->address=$newAddress;
        }
        $admin->save();

        return response()->json([
            "message"=>"updated successfully",
        ]);
    }
    public function accept($id){
        $worker = Worker::find($id);
        $worker->accepted = 1;
        $worker->save();
        return redirect()->route('workers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin=Admin::find($id);
        $admin->delete();
        return response()->json([
            "message"=>"deleted successfully",
        ]);
        //
    }

    public function delete($id){
        $worker= Worker::find($id);
        $worker->delete();
        return redirect()->route('workers');

    }

    public function paper($id){
        $w = Worker::find($id);
        return view('admin.workers.show')->with('w',$w);
    }

    public function evaluation(){
        $evs = Evaluation::all();
        return view('admin.evaluations.index')->with('evs',$evs);
    }

    public function showUser($id,$id2){
        $user = User::find($id);
        $worker = Worker::find($id2);

        return view('admin.evaluations.user')->with('user',$user)->with('worker',$worker);
    }
    public function showWorker($id){
        $worker = Worker::find($id);
        return view('admin.evaluations.worker')->with('worker',$worker);
    }

    public function banWorker($id){
        $worker = Worker::find($id);
        $worker->ban = 1;
        $worker->save();
        return redirect()->back();
    }
    public function unbanWorker($id){
        $worker = Worker::find($id);
        $worker->ban = 0;
        $worker->save();
        return redirect()->back();
    }

  public function showUserComplaints(){
        $comps = Complain::all()->where('complainant','=','user')->where('solved','=',0);
        return view('admin.complaints.index')->with('comps',$comps);
  }

  public function showComplaintsDetails($id){
      $details=DB::table('complains')
          ->join('jobs','complains.job_id','=','jobs.id')
          ->join('jop_requests','jobs.request_id','=','jop_requests.id')
          ->where('complains.id',$id)

          ->get();
      dd($details,$this->all());
      return view('admin.complaints.complaint')->with('details',$details);
  }

  public function storeCity(Request $request){
           $city =new City();

           $city->city = $request->input('name');
           $city->save();

           return response()->json([
               "message"=>'successfully Added'
           ]);

  }

  public function storeRegion(Request $request){
        $reg = new Region();
        $reg->reg = $request->input('name');
        $reg->city_id =$request->input('city');
        $reg->save();
      return response()->json([
          "message"=>'successfully Added'
      ]);

  }

}
