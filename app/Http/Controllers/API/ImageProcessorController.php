<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IndexResource;
use App\Models\ImageProcessor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageProcessorController extends Controller
{
    public function index(): JsonResource
    {
        $model = ImageProcessor::all();

        return new IndexResource($model);
    }

    public function get(int $id): JsonResource
    {
        $model = ImageProcessor::find($id);

        return new IndexResource($model);
    }

    public function post(Request $request): JsonResource
    {

    }
}
