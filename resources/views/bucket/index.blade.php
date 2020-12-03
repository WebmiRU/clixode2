@extends('index')

@section('content')
    <h1>Bucket index</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Type</th>
            {{--            <th>Created at</th>--}}
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($model as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->title}}</td>
                <td>FILES</td>
                {{--                <td>{{$v->created_at}}</td>--}}
                <td>
                    <a href="{{route('bucket.edit', ['id' => $v->id])}}">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
