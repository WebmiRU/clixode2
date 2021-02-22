<?php

namespace App\Http\Resources\DownloadTask;

use App\Http\Resources\Ref\DownloadTaskStatusResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DownloadTaskGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'progress' => $this->progress,
//            'bucket' => $this->bucket_id,
            'status' => new DownloadTaskStatusResource($this->status),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
