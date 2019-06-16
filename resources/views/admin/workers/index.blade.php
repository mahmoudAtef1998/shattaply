@extends('layouts.app')


@section('content')
    <table class="table table-hover">
        <thead>
        <th>
           Name
        </th>


        <th>age</th>
        <th>
            email
        </th>
        <th>
            work
        </th>
        <th>
            phone
        </th>
        <th>
            address
        </th>
        <th>
            national card
        </th>
        <th>
            average salary
        </th>
        <th>
            total rate
        </th>
        <th>
            show papers
        </th>
        <th>
            Accept
        </th>
        <th>
            Ban
        </th>
        <th>
            Delete
        </th>
        </thead>
        <tbody>
        @foreach($workers as $w)
            <tr>
                <td>
                    {{$w->name}}
                </td>
                <td>
                    {{$w->age}}
                </td>
                <td>
                    {{$w->email}}
                </td>
                <td>
                    {{$w->work}}
                </td>
                <td>
                    {{$w->phone}}
                </td>
                <td>
                    {{$w->address}}
                </td>
                <td>
                    {{$w->national_card}}
                </td>
                <td>
                    {{$w->average_salary}}
                </td>
                <td>
                    {{$w->total_rate}}
                </td>

                <td>
                    <a href="{{route('show.papers',['id'=> $w->id])}}" class="btn btn-sm btn-primary">show papers</a>
                </td>

               @if($w->accepted==0)
                    <td>
                        <a href="{{route('worker.accept',['id'=>$w->id])}}" class="btn btn-sm btn-success">Accept</a>
                    </td>
                @else
                    <td>
                       Accepted
                    </td>
                @endif
                @if($w->ban==0)
                    <td>
                        <a href="{{route('worker.ban',['id'=>$w->id])}}" class="btn btn-sm btn-warning">Ban</a>
                    </td>
                @else
                    <td>
                        <a href="" class="btn btn-sm btn-success">Un Ban</a>
                    </td>
                @endif

                <td>
                    <a href="{{route('worker.delete',['id'=>$w->id])}}" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection