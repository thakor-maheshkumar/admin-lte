@extends('adminlte::page')
@section('content')
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Subject</th>
            <th>UserName</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td>{{$log->id}}</td>
            <td>{{$log->subject}}</td>
            <td>{{$log->id}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection