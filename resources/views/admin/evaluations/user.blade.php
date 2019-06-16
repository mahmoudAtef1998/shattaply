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
            show Evaluated Worker
        </th>

        </thead>
        <tbody>

            <tr>
                <td>
                    {{$user->name}}
                </td>

                <td>
                    {{ $user->address}}
                </td>

                <td>
                    {{$user->email}}
                </td>

                <td>
                    {{$user->phone_number}}
                </td>

                <td>
                    <a href="{{route('worker.show',['id'=>$worker->id])}}" class="btn btn-sm btn-info">Show Evaluated Worker</a>
                </td>

            </tr>

        </tbody>
    </table>
@endsection