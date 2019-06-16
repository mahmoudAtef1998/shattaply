@extends('layouts.app')


@section('content')
    <table class="table table-hover">
        <thead>
        <th>
            Description
        </th>
        <th>
            View Details
        </th>

        <th>
            Resolved
        </th>
        </thead>
        <tbody>
        @foreach($comps as $comp)
            <tr>
                <td width="60%">
                    {{$comp->comp_description}}
                </td>

                <td width="20%">
                    <a href="{{route('details',['id'=>$comp->id])}}" class="btn btn-lg btn-info">View Details</a>
                </td>

                <td width="20%">
                    <a href="" class="btn btn-lg btn-success">Resolved</a>
                </td>


            </tr>
        @endforeach
        </tbody>
    </table>
@endsection