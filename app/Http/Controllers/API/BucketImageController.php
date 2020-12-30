<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IndexResource;
use App\Models\Bucket;
use Illuminate\Http\Resources\Json\JsonResource;

class BucketImageController extends Controller
{
    public function index(): JsonResource
    {
        $model = Bucket::query()
//            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return new IndexResource($model);
    }

    public function get(int $id): JsonResource
    {
        $model = Bucket::query()
            ->with('files.file')
            ->with('images.image')
            ->find($id);

        return new IndexResource($model);
    }

    public function post(): JsonResource
    {

    }
}
