<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageProcessorResource;
use App\Http\Resources\IndexResource;
use App\Models\ImageProcessor;
use App\Models\ImageProcessorActionParamValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImageProcessorController extends Controller
{
    public function index(): ResourceCollection
    {
        $model = ImageProcessor::all();

        return IndexResource::collection($model);
    }

    public function get(int $id): JsonResource
    {
        $model = ImageProcessor::with('actions.params', 'actionParamValues')->find($id);

        return new ImageProcessorResource($model);
    }

    public function post(Request $request): JsonResource
    {

    }

    public function put(Request $request, int $id)
    {
        $model = ImageProcessor::find($id);

        DB::beginTransaction();

        try {
            if ($model) {
                $model->update([
                    'title' => $request->get('title'),
                ]);
            }

            foreach ($request->get('actions', []) as $action) {
                foreach ($action['params'] as $param) {
                    if (mb_strlen($param['value'])) {
                        ImageProcessorActionParamValue::updateOrCreate([
                            'image_processor_action_param_id' => $param['id'],
                            'image_processor_id' => $model->id,
                        ],
                        [
                            'value' => $param['value'],
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (Throwable $e) {
            //@TODO Return error
            DB::rollBack();
        }

        $model = ImageProcessor::with('actions.params', 'actionParamValues')->find($id);

        return new ImageProcessorResource($model);
    }
}
