@extends('index')

@section('content')
    <h1>{{$model->name}}</h1>

    <form method="post">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$model->name}}">
        </div>

        <div class="mb-3">
            <label for="bucket_id" class="form-label">Bucket</label>
            <select class="form-control" id="bucket_id" name="bucket_id">
                @foreach($buckets as $v)
                    <option value="{{$v->id}}" {{ $model->bucket_id == $v->id ? 'selected' : null }}>{{$v->title}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <a href="{{route('bucket.edit', ['id' => $model->bucket_id])}}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
@endsection
