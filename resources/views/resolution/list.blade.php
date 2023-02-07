@section('plugins.Datatables', true)

@extends('adminlte::page')
@section('plugins.Datatables', true)

@section('content')
<br>
<br>
    <a href="{{route('resolution.create')}}" class="btn btn-primary">Add Solution</a>
    <div class="card">
<div class="card-header">
<h3 class="card-title">DataTable with default features</h3>
</div>

<div class="card-body">
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
<th>Language</th>
<th>Title</th>
<th>Link</th>
</tr>
</thead>
<tbody>
    @foreach($resolutions as $resolution)
<tr>
<td>{{$resolution->language}}</td>
<td>{{$resolution->title}}</td>
<td>{{$resolution->link}}</td>
@endforeach
</tr>

</table>
</div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('#example1').DataTable();
    })
</script>
@endsection