<?php

namespace App\Http\Resources\BucketFile;

use App\Http\Resources\BucketResource;
use App\Http\Resources\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BucketFileGetResource extends JsonResource
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
            'name' => $this->name,
            'uri' => $this->uri,
            'bucket' => new BucketResource($this->bucket),
            'file' => new FileResource($this->file),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
