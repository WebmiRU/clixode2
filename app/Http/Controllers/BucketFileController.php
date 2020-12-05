<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use App\Models\BucketFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BucketFileController extends Controller
{
    public function edit(int $id): View
    {
        $model = BucketFile::find($id);
        $buckets = Bucket::where('user_id', Auth::id())->get();

        return view('bucket_file.edit', [
            'model' => $model,
            'buckets' => $buckets,
        ]);
    }

    public function post(Request $request)
    {

    }

    public function put(Request $request, int $id): RedirectResponse
    {
        $model = BucketFile::query()
            ->where('id', $id)
            ->first();

        $model->update($request->all());

        return redirect()->back();
    }

    public function delete(int $id): RedirectResponse
    {
        $model = BucketFile::find($id);

        if($model) {
            $model->delete();
        }

        return redirect()->back();
    }
}
