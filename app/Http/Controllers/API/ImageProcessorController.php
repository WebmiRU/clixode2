<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        $model = ImageProcessor::with('actions')->find($id);

        return new IndexResource($model);
    }

    public function post(Request $request): JsonResource
    {

    }
}
