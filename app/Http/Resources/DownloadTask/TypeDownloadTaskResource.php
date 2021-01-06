<?php

namespace App\Http\Resources\DownloadTask;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeDownloadTaskResource extends JsonResource
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
            'type' => 'download_task',
            'data' => new DownloadTaskGetResource($this),
        ];
    }
}
