@extends('layouts.app')


@section('content')
    <table class="table table-hover">
        <thead>
        <th>
            Service Description
        </th>
        <th>
            worker moral
        </th>
        <th>
            rate
        </th>
        <th>Service Time</th>
        <th>
            Show user
        </th>
        <th>
            Show worker
        </th>
        </thead>
        <tbody>
        @foreach($evs as $ev)
            <tr>
                <td>
                    {{$ev->service_description}}
                </td>

                <td>
                    {{ $ev->worker_moral}}
                </td>

                <td>
                    {{$ev->rate}}
                </td>

                <td>
                    {{$ev->service_time}}
                </td>
                <td>
                    <a href="{{route('user.show',['id'=>$ev->user_id,'id2'=>$ev->worker_id])}}" class="btn btn-sm btn-info">Show user</a>
                </td>
                <td>
                    <a href="{{route('worker.show',['id'=>$ev->worker_id])}}" class="btn btn-sm btn-info">Show Worker</a>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
@endsection