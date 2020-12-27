<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageProcessorResource;
use App\Http\Resources\IndexResource;
use App\Models\ImageProcessor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ImageProcessorController extends Controller
{
    public function index(): ResourceCollection
    {
        $model = ImageProcessor::all();

        return IndexResource::collection($model);
    }

    public function get(int $id): JsonResource
    {
        $model = ImageProcessor::with('actions.params', 'actionParamValues')->find($id);

        return new ImageProcessorResource($model);
    }

    public function post(Request $request): JsonResource
    {

    }

    public function put(Request $request, int $id) {
        $model = ImageProcessor::find($id);

        if($model) {
            $model->update([
                'title' => $request->get('title'),
            ]);
        }

        $model = ImageProcessor::with('actions.params', 'actionParamValues')->find($id);

        return new ImageProcessorResource($model);
    }
}
