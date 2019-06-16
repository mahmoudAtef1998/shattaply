@extends('layouts.app')


@section('content')
    <table class="table table-hover">
        <thead>
        <th>
            name
        </th>
        <th>
            Address
        </th>
        <th>
            Email
        </th>
        <th>phone Number</th>
        <th>
          Ban Worker
        </th>
        <th>
            Block Worker
        </th>

        </thead>
        <tbody>

        <tr>
            <td>
                {{$worker->name}}
            </td>

            <td>
                {{ $worker->address}}
            </td>

            <td>
                {{$worker->email}}
            </td>

            <td>
                {{$worker->phone}}
            </td>

            @if($worker->ban==0)
                <td>
                    <a href="{{route('worker.ban',['id'=>$worker->id])}}" class="btn btn-sm btn-warning">Ban</a>
                </td>
            @else
                <td>
                    <a href="{{route('worker.unban',['id'=>$worker->id])}}}" class="btn btn-sm btn-success">Un Ban</a>
                </td>
            @endif
            <td>
                <a href="" class="btn btn-sm btn-danger">Block</a>
            </td>

        </tr>

        </tbody>
    </table>
@endsection