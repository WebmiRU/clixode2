<?php

namespace App\Http\Controllers;

use App\Models\ImageProcessor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImageProcessorController extends Controller
{
    public function index(): View
    {
        $model = ImageProcessor::query()
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('image_processor.index', ['model' => $model]);
    }

    public function edit(Request $request, int $id): View
    {
        $model = ImageProcessor::query()
            ->with('actions.params')
            ->with('actionParamValues')
            ->find($id);

        return view('image_processor.edit', ['model' => $model]);
    }

    public function post(Request $request)
    {

    }

    public function put(Request $request, int $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $model = ImageProcessor::find($id);
            $model->update($request->all());

            foreach ($request->get('param', []) as $paramId => $paramValue) {
                $model->actionParamValues()
                    ->where('image_processor_action_param_id', $paramId)
                    ->firstOrNew()
                    ->fill([
                        'image_processor_action_param_id' => $paramId,
                        'value' => $paramValue,
                    ])
                    ->save();
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            dd($e);
        }

        return redirect()->back();
    }

    public function delete(int $id)
    {

    }
}
