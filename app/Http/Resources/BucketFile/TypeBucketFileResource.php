<?php

namespace App\Http\Resources\BucketFile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeBucketFileResource extends JsonResource
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
            'type' => 'bucket_file',
            'data' => new BucketFileGetResource($this),
        ];
    }
}
