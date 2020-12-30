<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageProcessorResource;
use App\Http\Resources\IndexResource;
use App\Models\ImageProcessor;
use App\Models\ImageProcessorAction;
use App\Models\ImageProcessorActionParamValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
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
        $model = ImageProcessor::query()
            ->with('actions.params')
            ->with('actionParamValues')
            ->find($id);

        return new ImageProcessorResource($model);
    }

    public function post(Request $request): JsonResource
    {
        $model = ImageProcessor::query()
            ->create($request->all())
            ->load('actions.params')
            ->load('actionParamValues');

        return new IndexResource($model);
    }

    public function put(Request $request, int $id): JsonResource
    {
        $model = ImageProcessor::find($id);
        $actionIds = Arr::pluck($request->get('actions', []), 'id');

        DB::beginTransaction();

        try {
            if ($model) {
                $model->update([
                    'title' => $request->get('title'),
                ]);
            }

            //@TODO такой вариант не даёт добавить несколько одинаковых действий
            $model->actions()->sync($actionIds);

            foreach ($request->get('actions', []) as $action) {
                foreach ($action['params'] as $param) {
                    if (mb_strlen($param['value'] ?? null)) {
                        ImageProcessorActionParamValue::updateOrCreate(
                            [
                                'image_processor_action_param_id' => $param['id'],
                                'image_processor_id' => $model->id,
                            ],
                            [
                                'value' => $param['value'],
                            ]
                        );
                    }
                }
            }

            DB::commit();
        } catch (Throwable $e) {
            //@TODO Return error
            dd($e->getMessage());
            DB::rollBack();
        }

        $model = ImageProcessor::with('actions.params', 'actionParamValues')->find($id);

        return new ImageProcessorResource($model);
    }

    public function actions(): JsonResource
    {
        $model = ImageProcessorAction::query()
            ->with('params')
            ->orderBy('id', 'desc')
            ->get();

        return new IndexResource($model);
    }
}
