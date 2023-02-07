@extends('adminlte::page')
@section('content')
<a href="{{route('image-upload')}}" class="btn btn-primary">Add Iamges</a>
<table>
    <thead>
        <tr>
            <th>Images</th>
        </tr>
    </thead>
    <tbody>
        @foreach($images as $key=>$value)
        <tr>
            <td> <?php foreach (json_decode($value->image_path)as $picture) { ?>
                 <img src="{{ asset('/uploads/'.$picture) }}" style="height:120px; width:200px"/>
                <?php } ?>
           </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection