<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageProcessorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        foreach ($this->actions as &$action) {
            foreach ($action->params as &$param) {
                $param->value = $this->actionParamValues->where('image_processor_action_param_id', $param->id)->first()->value ?? null;
            }
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'actions' => $this->actions,
        ];
    }
}
