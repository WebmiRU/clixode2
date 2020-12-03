@extends('index')

@section('content')
    <h1>{{$model->title}}</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Size</th>
            <th>SHA256</th>
        </tr>
        </thead>
        <tbody>
        @foreach($model->files as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->name}}</td>
                <td>{{$v->file->size}}</td>
                <td>{{$v->file->sha256}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
