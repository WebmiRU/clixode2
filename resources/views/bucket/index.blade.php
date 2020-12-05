@extends('index')

@section('content')
    <h1>Bucket index</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="narrow">#</th>
            <th>Title</th>
            <th>Type</th>
            {{--            <th>Created at</th>--}}
            <th class="narrow">Edit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($model as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->title}}</td>
                <td>{{$v->type}}</td>
                {{--                <td>{{$v->created_at}}</td>--}}
                <td>
                    <a class="btn btn-sm btn-warning" href="{{route('bucket.edit', ['id' => $v->id])}}">Edit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
