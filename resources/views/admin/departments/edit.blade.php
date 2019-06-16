@extends('layouts.app')


@section('content')
    <h2 class="text-center"> Create New Department</h2>

    <div class="card">
        <div class="card-header">
           Update Department
        </div>
        <div class="card-body">
            <form action="{{route('department.update',['id'=>$dept->id])}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{$dept->name}}">
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <input type="text" name="type" class="form-control" value="{{$dept->type}}">
                </div>
                <div class="form-group">
                    <label for="desc">description</label>
                    <textarea type="text" name="desc" class="form-control">{{$dept->description}}</textarea>
                </div>
                <div class="form-group">

                    <button type="submit"  class="btn btn-success">update</button>
                </div>

            </form>
        </div>
    </div>

@endsection