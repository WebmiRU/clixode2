@extends('index')

@section('content')
    <h1>{{$model->title}}</h1>

    <ul>
        @foreach($model->imageProcessors ?? [] as $imageProcessor)
            <li>{{$imageProcessor->title}}</li>
        @endforeach
    </ul>

    <form method="post" action="{{route('bucket.put', ['id' => $model->id])}}">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$model->title}}"/>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>

    <form method="post" action="{{route('file.post')}}" enctype="multipart/form-data">
        @method('POST')
        @csrf

        <input type="hidden" name="bucket_id" value="{{$model->id}}"/>

        <div class="mb-3">
            <label for="name" class="form-label">File by upload</label>
            <input type="file" class="form-control" id="file" name="file"/>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">File by link</label>
            <input type="text" class="form-control" id="link" name="link"/>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">Add file</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="narrow">#</th>
            <th>Name</th>
            <th>Size</th>
            <th>MIME type</th>
            <th>Link</th>
            <th class="narrow">Edit</th>
            <th class="narrow">Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($model->files as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->name}}</td>
                <td>{{$v->file->size}}</td>
                <td>{{$v->file->mime_type}}</td>
                <td><a href="{{route('file.get', ['uri' => $v->uri])}}">Download</a></td>
                <td>
                    <a href="{{route('bucket-file.edit', ['id' => $v->id])}}" class="btn btn-warning">Edit</a>
                </td>
                <td>
                    <form method="post" action="{{route('bucket-file.delete', ['id' => $v->id])}}">
                        @method('DELETE')
                        @csrf

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <ul>
    @foreach($model->images as $v)
        <li>{{$v->id}} / {{$v->image->sha256}}</li>
    @endforeach
    </ul>
@endsection
