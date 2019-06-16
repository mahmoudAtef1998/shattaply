<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
public function all(){
    return view('admin.departments.index')->with('deps',Department::all());
}
    public function index()
    {
        $departments=Department::all();
        return response()->json([
            "message"=>"successfull",
            "data"=> $departments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:departments'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                "message"=>"failed",
                "data"=> $errors
            ]);
        }

        $department=new Department();
        $department->description=$request->input('description');
        $department->name=$request->input('name');
        $department->type=$request->input('type');
        $department->save();
        return response()->json([
            "message"=>"successfull",
            "data"=> $department
        ]);
    }
  public function save(Request $request){

      $validator = Validator::make($request->all(),[
          'name'=>'required|unique:departments'
      ]);
      if ($validator->fails()) {
        echo ' a7a';
      }
      else{
      $department=new Department();
      $department->description=$request->desc;
      $department->name=$request->name;
      $department->type=$request->type;

      $department->save();
      return redirect()->route('departments');
      }
  }
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
        $dept=Department::find($id);

        return view('admin.departments.edit')->with('dept',$dept);
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
        $department = Department::find($id);


        $department->description=$request->name;
        $department->name=$request->type;
        $department->type=$request->desc;
        $department->save();
        return redirect()->route('departments');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $department = Department::find($id);
        $department->delete();
        return redirect()->route('departments');

    }

}
