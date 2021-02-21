<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DownloadTask\DownloadTaskGetResource;
use App\Models\DownloadTask;
use Illuminate\Http\Request;

class DownloadTaskController extends Controller
{

    public function checkStatus(Request $request)
    {
        $idArr = collect($request->all())->pluck('id');

        $model = DownloadTask::query()
            ->with('status')
            ->whereIn('id', $idArr)
            ->whereIn('ref_download_task_status_id', ['1', '5', '10'])
            ->orderBy('id', 'DESC')
            ->get();

        return DownloadTaskGetResource::collection($model);
    }
}
