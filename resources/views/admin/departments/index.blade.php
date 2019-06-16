@extends('layouts.app')


@section('content')
     <table class="table table-hover">
         <thead>
            <th>
                 Department Name
            </th>
            <th>
                  Type
            </th>
           <th>
               description
           </th>
           <th>Edit</th>
         <th>
             Delete
         </th>
         </thead>
         <tbody>
           @foreach($deps as $dep)
               <tr>
                   <td>
                       {{$dep->name}}
                   </td>

                   <td>
                       {{$dep->type}}
                   </td>

                   <td>
                       {{$dep->description}}
                   </td>

                   <td>
                       <a href="{{ route('department.edit',['id' => $dep->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                   </td>

                   <td>
                       <a href="{{route('department.delete',['id'=>$dep->id])}}" class="btn btn-sm btn-danger">Delete</a>
                   </td>
               </tr>
              @endforeach
         </tbody>
     </table>
@endsection