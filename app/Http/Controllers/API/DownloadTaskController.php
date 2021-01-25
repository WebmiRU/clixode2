<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DownloadTask\DownloadTaskGetResource;
use App\Models\DownloadTask;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DownloadTaskController extends Controller
{

    public function index(int $bucketId): AnonymousResourceCollection
    {
//        $bucketId = $request->get('bucket_id');
        $model = DownloadTask::query()
            ->with('status')
            ->where('bucket_id', $bucketId)
            ->whereIn('ref_download_task_status_id', ['1', '5', '10'])
            ->orderBy('id', 'DESC')
            ->get();

        return DownloadTaskGetResource::collection($model);
    }
}
