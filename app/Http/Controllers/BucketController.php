<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class BucketController extends Controller
{
    public function index(): View
    {
        $model = Bucket::query()
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('bucket.index', ['model' => $model]);
    }

    public function edit(Request $request, int $id): View
    {
        $model = Bucket::query()
            ->with('files.file')
            ->with('imageProcessors')
            ->find($id);

        return view('bucket.edit', ['model' => $model]);
    }

    public function post(Request $request)
    {

    }

    public function put(Request $request, int $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $model = Bucket::find($id);
            $model->update($request->all());

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }



        return redirect()->back();
    }

    public function delete(int $id)
    {

    }
}
