@section('plugins.parsley', true)

@extends('adminlte::page')
@section('content')
<div class="container">
    <form id="formData" action="{{url('resolution/store')}}" method="post">
        @csrf
        <h2>Add Solution</h2>
        <div class="row">
            <div class="col-md-6">
                <label>Select Category</label>
                    <select name="language" id="" class="form-control">
                        <option value="php">PHP</option>
                        <option value="laravel">Laravel</option>
                        <option value="node js">Node js</option>
                        <option value="Angular">Angular</option>
                    </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6" >
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <label>Link</label>
            <input type="text" class="form-control" name="link" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <label>Description</label>
            <textarea name="description" id="" rows="5" class="form-control" required></textarea>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
  <form>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('#formData').parsley();
    });

</script>
@stop

