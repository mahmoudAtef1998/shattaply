@extends('layouts.app')


@section('content')
   <h2 class="text-center"> Create New Department</h2>

    <div class="card">
        <div class="card-header">
            Create a New Department
        </div>
        <div class="card-body">
            <form action="{{route('department.save')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <input type="text" name="type" class="form-control">
                </div>
                <div class="form-group">
                    <label for="desc">description</label>
                    <textarea type="text" name="desc" class="form-control"></textarea>
                </div>
                <div class="form-group">

                    <button type="submit"  class="btn btn-success">Save</button>
                </div>

            </form>
        </div>
    </div>

@endsection