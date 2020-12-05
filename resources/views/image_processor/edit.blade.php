@extends('index')

@section('content')
    <h1>{{$model->title}}</h1>

    <form method="post" action="{{route('image-processor.put', ['id' => $model->id])}}">
        @method('PUT')
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$model->title}}"/>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">Save</button>
        </div>


        <table class="table table-striped">
            <thead>
            <tr>
                <th class="narrow">#</th>
                <th>Name</th>
                <th class="narrow">Edit</th>
                <th class="narrow">Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($model->actions as $action)
                <tr>
                    <td>{{$action->id}}</td>
                    <td>{{$action->name}}</td>
                    <td>
                        <a href="{{route('bucket-file.edit', ['id' => $action->id])}}"
                           class="btn btn-sm btn-warning">Edit</a>
                    </td>
                    <td>
{{--                        <form method="post" action="{{route('bucket-file.delete', ['id' => $action->id])}}">--}}
{{--                            @method('DELETE')--}}
{{--                            @csrf--}}

                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
{{--                        </form>--}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        @foreach($action->params as $param)
                            @switch($param->type)
                                @case('INT')
                                <div class="mb-3">
                                    <label for="param_{{$param}}" class="form-label">{{$param->title}}</label>
                                    <input type="text" class="form-control" id="param_{{$param}}" name="param[{{$param->id}}]" value="{{$model->actionParamValues->where('image_processor_action_param_id', $param->id)->first()->value ?? null}}"/>
                                </div>
                                @break

                                @case('BOOL')
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="hidden" class="form-control" id="param_{{$param->id}}" name="param[{{$param->id}}]" value="0"/>
                                        <input class="form-check-input" type="checkbox" value="1" id="param_{{$param->id}}" name="param[{{$param->id}}]" {{!($model->actionParamValues->where('image_processor_action_param_id', $param->id)->first()->value ?? null) ?: 'checked'}} />
                                        <label class="form-check-label" for="param_{{$param->id}}">
                                            {{$param->title}}
                                        </label>
                                    </div>
                                </div>
                                @break
                            @endswitch
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>
@endsection
