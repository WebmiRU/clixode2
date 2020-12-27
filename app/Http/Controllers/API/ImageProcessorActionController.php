<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IndexResource;
use App\Models\ImageProcessorAction;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageProcessorActionController extends Controller
{
    public function index(): JsonResource
    {
        $model = ImageProcessorAction::query()
            ->with('params')
            ->orderBy('id', 'desc')
            ->get();

        return new IndexResource($model);
    }
}
